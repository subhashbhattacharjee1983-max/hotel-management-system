<?php
namespace App\Controller;

use Cake\Http\Client;

class OcrController extends AppController
{
	public function aadhaar()
	{
		$this->viewBuilder()->setLayout('ajax');
		$this->request->allowMethod(['post']);
		$this->autoRender = false;

		try {

			$file = $this->request->getData('aadhaar_image');

			if (empty($file)) {
				throw new \Exception('No file uploaded');
			}

			// CakePHP UploadedFile
			if (is_object($file)) {

				$tmpPath = $file->getStream()->getMetadata('uri');
				$originalName = $file->getClientFilename();

			} elseif (is_array($file) && isset($file['tmp_name'])) {

				$tmpPath = $file['tmp_name'];
				$originalName = $file['name'];

			} else {

				throw new \Exception('Invalid uploaded file');
			}

			if (!file_exists($tmpPath)) {
				throw new \Exception('Temporary file not found');
			}

			// Create temp file with original extension
			$ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

			$allowed = ['jpg','jpeg','png','gif','bmp','tif','tiff','webp','pdf'];

			if (!in_array($ext, $allowed)) {
				throw new \Exception('Invalid file type: ' . $ext);
			}

			$ocrFile = WWW_ROOT . 'aadhaar_' . time() . '.' . $ext;

			copy($tmpPath, $ocrFile);

			$curl = curl_init();

			curl_setopt_array($curl, [
				CURLOPT_URL => 'https://api.ocr.space/parse/image',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_POST => true,

				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_SSL_VERIFYHOST => false,

				CURLOPT_POSTFIELDS => [
					'apikey' => 'helloworld', // Replace with your OCR.Space API key is AIzaSyBxqDZQThRES4Jcwlh9RUwHJUoL9yDUGfE
					'language' => 'eng',
					'isOverlayRequired' => 'false',
					'file' => new \CURLFile(
						$ocrFile,
						mime_content_type($ocrFile),
						basename($ocrFile)
					)
				]
			]);

			$result = curl_exec($curl);

			if (curl_errno($curl)) {
				throw new \Exception(curl_error($curl));
			}

			curl_close($curl);

			$ocr = json_decode($result, true);

			file_put_contents(
				LOGS . 'ocr_response.json',
				json_encode($ocr, JSON_PRETTY_PRINT)
			);

			if (!empty($ocr['IsErroredOnProcessing'])) {

				throw new \Exception(
					implode(', ', $ocr['ErrorMessage'] ?? ['OCR processing failed'])
				);
			}

			$text = $ocr['ParsedResults'][0]['ParsedText'] ?? '';

			file_put_contents(
				LOGS . 'aadhaar_ocr.txt',
				$text
			);

			// Aadhaar Number
			preg_match('/\b\d{4}\s?\d{4}\s?\d{4}\b/', $text, $aadhaar);

			// DOB
			preg_match('/\d{2}[\/\-]\d{2}[\/\-]\d{4}/', $text, $dob);

			// PIN Code
            preg_match('/\b\d{6}\b/', $text, $pin);

			$name = '';

			$lines = preg_split("/\r\n|\n|\r/", $text);

			foreach ($lines as $line) {

				$line = trim($line);

				if (
					strlen($line) > 3 &&
					!preg_match('/\d/', $line) &&
					stripos($line, 'government') === false &&
					stripos($line, 'india') === false &&
					stripos($line, 'unique') === false &&
					stripos($line, 'identification') === false &&
					stripos($line, 'authority') === false &&
					stripos($line, 'male') === false &&
					stripos($line, 'female') === false &&
					stripos($line, 'dob') === false &&
                    stripos($line, 'address') === false
				) {
					$name = $line;
					break;
				}
			}

			// Address Extraction
            $addressParts = [];
            $captureAddress = false;

            foreach ($lines as $line) {

                $line = trim($line);

                if (
                    stripos($line, 'Address') !== false ||
                    stripos($line, 'C/O') !== false ||
                    stripos($line, 'S/O') !== false ||
                    stripos($line, 'D/O') !== false ||
                    stripos($line, 'W/O') !== false
                ) {
                    $captureAddress = true;
                }

                if ($captureAddress) {

                    $addressParts[] = $line;

                    if (
                        !empty($pin[0]) &&
                        strpos($line, $pin[0]) !== false
                    ) {
                        break;
                    }
                }
            }
			
			$address = explode("/ Your Aadhaar No",$text);

           /* $address = trim(
                implode(', ', array_filter($addressParts))
            );*/

			@unlink($ocrFile);

			$response = [
				'success' => true,
				'aadhaar_no' => $aadhaar[0] ?? '',
				'name' => $name,
				'dob' => $dob[0] ?? '',
				'pin_code' => $pin[0] ?? '',
                'address' => $address[0],
				'ocr_text' => $text
			];

		} catch (\Exception $e) {

			$response = [
				'success' => false,
				'message' => $e->getMessage()
			];
		}

		return $this->response
			->withType('application/json')
			->withStringBody(json_encode($response));

		exit;
	}
}
