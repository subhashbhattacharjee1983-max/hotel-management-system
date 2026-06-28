<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Master Bill Receipt - <?php echo $booking->customer->full_name; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <style>
        /* A4 Page Setup for Compact Layout */
        @page {
            size: A4;
            margin: 10mm 15mm;
        }

        body {
            font-family: "Arial", sans-serif;
            font-size: 11px;
            line-height: 1.3;
            color: #000;
            background-color: #fff;
            margin: 0;
            padding: 0;
        }

        .bill-container {
            width: 100%;
            max-width: 19cm;
            margin: 0 auto;
            background-color: #fff;
        }

        /* Original and Carbon Copy Layout */
        .copy-section {
            border: 1px solid #000;
            margin-bottom: 15px;
            padding: 15px;
            background-color: #fff;
            page-break-inside: avoid;
        }

        .carbon-copy {
            background-color: #f8f9fa;
            border-style: dashed;
        }

        .copy-header {
            text-align: center;
            padding: 8px 0;
            font-weight: bold;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }

        .original-copy {
            background-color: #e3f2fd;
        }

        .carbon-copy-header {
            background-color: #fff3e0;
        }

        /* Hotel Header - Compact */
        .hotel-header {
            text-align: center;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 1px solid #ddd;
        }

        .hotel-header h1 {
            font-size: 16px;
            font-weight: bold;
            margin: 0;
            color: #1976d2;
        }

        .hotel-header .subtitle {
            font-size: 12px;
            font-weight: bold;
            margin: 3px 0;
            color: #424242;
        }

        .hotel-header p {
            font-size: 9px;
            margin: 1px 0;
            color: #666;
        }

        /* Bill Information - Two Column Layout */
        .bill-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 10px;
        }

        .bill-info .left-col,
        .bill-info .right-col {
            width: 48%;
        }

        .info-row {
            display: flex;
            margin-bottom: 2px;
        }

        .info-label {
            font-weight: bold;
            width: 40%;
            color: #333;
        }

        .info-value {
            width: 60%;
        }

        /* Summary Table - Compact */
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
            font-size: 9px;
        }

        .summary-table th,
        .summary-table td {
            border: 1px solid #ddd;
            padding: 4px 6px;
            text-align: left;
        }

        .summary-table th {
            background-color: #f5f5f5;
            font-weight: bold;
            font-size: 8px;
            text-transform: uppercase;
        }

        .summary-table .amount {
            text-align: right;
            font-weight: bold;
        }

        .summary-table .total-row {
            background-color: #e8f5e8;
            font-weight: bold;
        }

        .summary-table .grand-total {
            background-color: #d4edda;
            font-size: 10px;
        }

        /* Payment Summary - Horizontal Layout */
        .payment-summary {
            display: flex;
            justify-content: space-between;
            margin: 8px 0;
            padding: 6px;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 3px;
        }

        .payment-item {
            text-align: center;
            font-size: 9px;
        }

        .payment-amount {
            font-size: 11px;
            font-weight: bold;
            color: #1976d2;
        }

        /* Footer Signatures */
        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
        }

        .signature-box {
            width: 30%;
            text-align: center;
            font-size: 8px;
        }

        .signature-line {
            border-top: 1px solid #333;
            margin: 20px 5px 5px 5px;
            padding-top: 3px;
        }

        /* Print Styles */
        @media print {
            .no-print {
                display: none !important;
            }

            .bill-container {
                box-shadow: none;
            }

            body {
                margin: 0;
                padding: 0;
            }

            .copy-section {
                margin-bottom: 10mm;
            }
        }

        /* Action Buttons */
        .action-buttons {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            display: flex;
            gap: 10px;
        }

        .btn-action {
            padding: 8px 15px;
            font-size: 12px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            color: white;
        }

        .btn-print {
            background-color: #28a745;
        }

        .btn-email {
            background-color: #007bff;
        }

        .btn-close {
            background-color: #6c757d;
        }

        .btn-action:hover {
            opacity: 0.9;
            color: white;
        }
    </style>
</head>

<body>
    <div class="action-buttons no-print">
        <button onclick="window.print()" class="btn-action btn-print"><i class="fas fa-print"></i> Print</button>
        <button onclick="showEmailModal()" class="btn-action btn-email"><i class="fas fa-envelope"></i> Email</button>
        <button onclick="window.close()" class="btn-action btn-close"><i class="fas fa-times"></i></button>
    </div>

    <div class="bill-container">
        <div class="copy-section">
            <div class="copy-header original-copy"><i class="fas fa-file-invoice"></i> ORIGINAL COPY - CUSTOMER COPY</div>

            <div class="hotel-header">
                <h1><i class="fas fa-hotel"></i> <?php echo $site_general_settings->company_name ?></h1>
                <div class="subtitle">MASTER BILL RECEIPT</div>
                <p><?php echo $site_general_settings->street_address ?> | Phone: <?php echo $site_general_settings->phone_number ?> | Email: <?php echo $site_general_settings->billing_email_address ?></p>
                <p><strong>Generated:</strong> <?php $now = new DateTime(); echo $timestring = $now->format('M d, Y h:i A'); ?> </p>
            </div>
            <div class="bill-info">
                <div class="left-col">
                    <div class="info-row">
                        <span class="info-label">Bill No:</span>
                        <span class="info-value">BILL-<?php echo date("Y") ?>-<?php echo $booking->id; ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Guest:</span>
                        <span class="info-value"><?php echo $booking->customer->full_name; ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Phone:</span>
                        <span class="info-value"><?php echo $booking->customer->mobile_number; ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Email:</span>
                        <span class="info-value"><?php echo $booking->customer->email_address; ?></span>
                    </div>
                </div>
                <?php $show_rooms = $this->Common->show_rooms($booking->id); ?>
                <div class="right-col">
                    <div class="info-row">
                        <span class="info-label">Room:</span>
                        <span class="info-value"><?php echo $show_rooms ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Check-in:</span>
                        <span class="info-value"><?php echo $this->Common->entry_date($booking->check_in_date);?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Check-out:</span>
                        <span class="info-value"><?php echo $this->Common->entry_date($booking->check_out_date);?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Nights:</span>
                        <span class="info-value"><?php echo $booking->number_of_night; ?></span>
                    </div>
                </div>
            </div>
			<?php
			$final_tally_summery = $this->Common->final_tally_summery($booking->id); 
			$tally_summery = explode("@",$final_tally_summery);
			$amount_payble = $tally_summery[0];
			$amount_received = $tally_summery[1];
			$outstanding = $tally_summery[2];
			?>
			<div class="bill-info">
				<div class="left-col" style="width: 50%;">
					<?php echo $this->Common->master_bill_receipt_debit($booking->id); ?>
				</div>
				<div class="right-col" style="width: 50%;">
					<?php echo $this->Common->masterbill_payment($booking->id); ?>
					<table class="summary-table" style="margin: 0px;">
						<tr class="grand-total">
							<td colspan="4" style="text-align: center;">
								<strong> <span style="color: #dc3545;">BALANCE DUE: <?php echo $site_general_settings->currency; ?><?php echo round($outstanding) ?></span> </strong>
							</td>
						</tr>
					</table>
				</div>
			</div>
            <div class="signature-section">
                <div class="signature-box">
                    <div style="font-weight: bold; margin-bottom: 5px;">Manager</div>
                    <div class="signature-line">Signature</div>
                </div>
                <div class="signature-box">
                    <div style="font-weight: bold; margin-bottom: 5px;">Guest</div>
                    <div class="signature-line">Signature</div>
                </div>
                <div class="signature-box">
                    <div style="font-weight: bold; margin-bottom: 5px;">Reception</div>
                    <div class="signature-line">Stamp & Sign</div>
                </div>
            </div>
            <div style="text-align: center; margin-top: 10px; font-size: 8px; color: #666; border-top: 1px dashed #ccc; padding-top: 5px;">
                <p style="margin: 2px 0;">This is a computer-generated bill. All charges are inclusive of applicable taxes.</p>
                <p style="margin: 2px 0;">Booking ID: BILL-<?php echo date("Y") ?>-<?php echo $booking->id; ?> | Generated: <?php $now = new DateTime(); echo $timestring = $now->format('M d, Y h:i A'); ?></p>
            </div>
        </div>
        <div class="copy-section carbon-copy">
            <div class="copy-header carbon-copy-header"><i class="fas fa-copy"></i> CARBON COPY - HOTEL RECORDS</div>

            <div class="hotel-header">
                <h1><i class="fas fa-hotel"></i> <?php echo $site_general_settings->company_name ?></h1>
                <div class="subtitle">MASTER BILL RECEIPT</div>
                <p><?php echo $site_general_settings->street_address ?> | Phone: <?php echo $site_general_settings->phone_number ?> | Email: <?php echo $site_general_settings->billing_email_address ?></p>
                <p><strong>Generated:</strong> <?php $now = new DateTime(); echo $timestring = $now->format('M d, Y h:i A'); ?> </p>
            </div>
            <div class="bill-info">
                <div class="left-col">
                    <div class="info-row">
                        <span class="info-label">Bill No:</span>
                        <span class="info-value">BILL-<?php echo date("Y") ?>-<?php echo $booking->id; ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Guest:</span>
                        <span class="info-value"><?php echo $booking->customer->full_name; ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Phone:</span>
                        <span class="info-value"><?php echo $booking->customer->mobile_number; ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Email:</span>
                        <span class="info-value"><?php echo $booking->customer->email_address; ?></span>
                    </div>
                </div>
                <div class="right-col">
                    <div class="info-row">
                        <span class="info-label">Room:</span>
                        <span class="info-value"><?php echo $show_rooms ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Check-in:</span>
                        <span class="info-value"><?php echo $this->Common->entry_date($booking->check_in_date);?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Check-out:</span>
                        <span class="info-value"><?php echo $this->Common->entry_date($booking->check_out_date);?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Nights:</span>
                        <span class="info-value"><?php echo $booking->number_of_night; ?></span>
                    </div>
                </div>
            </div>
            <div class="bill-info">
				<div class="left-col" style="width: 50%;">
					<?php echo $this->Common->master_bill_receipt_debit($booking->id); ?>
				</div>
				<div class="right-col" style="width: 50%;">
					<?php echo $this->Common->masterbill_payment($booking->id); ?>
					<table class="summary-table" style="margin: 0px;">
						<tr class="grand-total">
							<td colspan="4" style="text-align: center;">
								<strong> <span style="color: #dc3545;">BALANCE DUE: <?php echo $site_general_settings->currency; ?><?php echo round($outstanding) ?></span> </strong>
							</td>
						</tr>
					</table>
				</div>
			</div>
            <div class="signature-section">
                <div class="signature-box">
                    <div style="font-weight: bold; margin-bottom: 5px;">Manager</div>
                    <div class="signature-line">Signature</div>
                </div>
                <div class="signature-box">
                    <div style="font-weight: bold; margin-bottom: 5px;">Guest</div>
                    <div class="signature-line">Signature</div>
                </div>
                <div class="signature-box">
                    <div style="font-weight: bold; margin-bottom: 5px;">Reception</div>
                    <div class="signature-line">Stamp & Sign</div>
                </div>
            </div>
            <div style="text-align: center; margin-top: 10px; font-size: 8px; color: #666; border-top: 1px dashed #ccc; padding-top: 5px;">
                <p style="margin: 2px 0;">This is a computer-generated bill. All charges are inclusive of applicable taxes.</p>
                <p style="margin: 2px 0;">Booking ID: BILL-<?php echo date("Y") ?>-<?php echo $booking->id; ?> | Generated: <?php $now = new DateTime(); echo $timestring = $now->format('M d, Y h:i A'); ?></p>
            </div>
        </div>
    </div>
    <div class="modal fade" id="emailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-envelope"></i> Send Master Bill via Email</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="emailForm">
                        <div class="mb-3">
                            <label class="form-label">Recipient Email *</label>
                            <input type="email" class="form-control" id="recipientEmail" value="<?php echo $booking->customer->email_address; ?>" placeholder="Enter email address" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">CC Email (Optional)</label>
                            <input type="email" class="form-control" id="ccEmail" placeholder="Additional email address" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Subject</label>
                            <input type="text" class="form-control" id="emailSubject" value="Master Bill Receipt - <?php echo $booking->customer->full_name; ?> - Room <?php echo $show_rooms ?>" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Message</label>
                            <textarea class="form-control" id="emailMessage" rows="4">
Dear <?php echo $booking->customer->full_name; ?>,

Please find attached your Master Bill Receipt for your stay at our hotel.

Details:
- Guest: <?php echo $booking->customer->full_name; ?>- Room: <?php echo $show_rooms ?>- Check-in: <?php echo $this->Common->entry_date($booking->check_in_date);?>- Check-out: <?php echo $this->Common->entry_date($booking->check_out_date);?>- Total Amount: <?php echo $site_general_settings->currency; ?><?php echo round($amount_payble) ?> 
Thank you for choosing our hotel. We hope you had a pleasant stay.

Best regards,
<?php echo $site_general_settings->company_name ?> Team
                            </textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="sendEmail()"><i class="fas fa-paper-plane"></i> Send Email</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showEmailModal() {
            const modal = new bootstrap.Modal(document.getElementById("emailModal"));
            modal.show();
        }

        function sendEmail() {
            const form = document.getElementById("emailForm");
            const formData = new FormData();

            formData.append("booking_id", "BILL-<?php echo date('Y') ?>-<?php echo $booking->id; ?>");
            formData.append("recipient_email", document.getElementById("recipientEmail").value);
            formData.append("cc_email", document.getElementById("ccEmail").value);
            formData.append("subject", document.getElementById("emailSubject").value);
            formData.append("message", document.getElementById("emailMessage").value);
        }

        // Print optimization
        window.addEventListener("beforeprint", function() {
            document.title = "Master Bill - <?php echo $booking->customer->full_name; ?> - Room <?php echo $show_rooms ?>";
        });
    </script>
</body>

</html>