<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt #PAY-<?php echo date("Ymd",strtotime($booking->booking_date)) ?>-<?php echo $booking->id; ?></title>
    <style>
        @page { 
            size: 80mm auto; 
            margin: 2mm 5mm; 
        }
        body { 
            font-family: 'Courier New', monospace; 
            font-size: 11px; 
            line-height: 1.2; 
            color: #000; 
            background: #fff; 
            margin: 0; 
            padding: 10px; 
            font-weight: bold;
        }
        .receipt-container { 
            width: 300px; 
            margin: 0 auto; 
            background: #fff; 
            padding: 10px;
            border: 1px solid #ddd;
        }
        .receipt-header { 
            text-align: center; 
            border-bottom: 2px dashed #000; 
            padding-bottom: 8px; 
            margin-bottom: 8px; 
        }
        .receipt-header h1 { 
            font-size: 14px; 
            font-weight: 900; 
            margin: 0 0 2px 0; 
            letter-spacing: 1px; 
            color: #000;
        }
        .receipt-header .subtitle { 
            font-size: 12px; 
            font-weight: 900; 
            margin-bottom: 2px; 
            color: #000;
        }
        .receipt-header h2 { 
            font-size: 10px; 
            margin: 0; 
        }
        .info-section { 
            margin-bottom: 8px; 
            font-size: 10px; 
        }
        .info-section div { 
            margin-bottom: 1px; 
        }
        .payment-details { 
            border-top: 2px dashed #000; 
            padding-top: 8px; 
            margin-bottom: 8px; 
        }
        .payment-details .section-title { 
            text-align: center; 
            font-weight: 900; 
            margin-bottom: 4px; 
            color: #000;
        }
        .amount-section { 
            border-top: 2px dashed #000; 
            padding-top: 8px; 
            margin-bottom: 8px; 
        }
        .amount-line { 
            display: flex; 
            justify-content: space-between; 
            margin-bottom: 2px; 
        }
        .total-line { 
            border-top: 2px solid #000; 
            padding-top: 4px; 
            font-weight: 900; 
            color: #000;
        }
        .receipt-footer { 
            text-align: center; 
            font-size: 10px; 
            color: #000; 
            margin-top: 8px; 
            border-top: 2px dashed #000; 
            padding-top: 8px; 
            font-weight: bold;
        }
        .print-btn { 
            display: block; 
            margin-top: 15px;
        }
		table td {
			background: none !important;
			font-size: 9px;
		}
		table tr {
			background: none !important;
			font-size: 9px;
		}
		table td img {
			display: none !important;
		}
        @media print { 
            .print-btn { display: none !important; } 
            body { 
                padding: 0; 
                margin: 0;
                font-family: 'Courier New', monospace !important;
                font-size: 11px !important;
                line-height: 1.2 !important;
                font-weight: 900 !important;
                color: #000 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .receipt-container { 
                border: none !important; 
                width: 80mm !important; 
                max-width: 80mm !important;
                margin: 0 auto !important; 
                padding: 0 !important; 
                box-shadow: none !important;
            }
            .receipt-header,
            .info-section,
            .payment-details,
            .amount-section,
            .receipt-footer {
                width: 100% !important;
                max-width: 100% !important;
            }
                         .amount-line {
                 display: flex !important;
                 justify-content: space-between !important;
             }
         }
         
         /* Additional thermal print optimization */
         .thermal-print .receipt-container {
             width: 80mm !important;
             max-width: 80mm !important;
             font-family: 'Courier New', monospace !important;
             font-size: 10px !important;
             font-weight: 900 !important;
             color: #000 !important;
         }
         
         /* Make all text elements darker for thermal printing */
         .receipt-container * {
             color: #000 !important;
             font-weight: inherit;
         }
         
         .receipt-container strong,
         .receipt-container .section-title,
         .receipt-container .total-line,
         .receipt-container h1,
         .receipt-container h2,
         .receipt-container .subtitle {
             font-weight: 900 !important;
             color: #000 !important;
         }
    </style>
</head>
<body>
    <div class="receipt-container">
        <!-- Header -->
        <div class="receipt-header">
            <h1><?php echo $site_general_settings->company_name ?></h1>
            <div class="subtitle">PAYMENT RECEIPT</div>
            <h2>#PAY-<?php echo date("Ymd") ?>-<?php echo $booking->id; ?></h2>
        </div>
        
        <!-- Customer & Booking Info -->
        <div class="info-section">
            <div><strong>Date:</strong> <?php echo date("M d, Y H:i A",strtotime($booking->booking_date));?></div>
            <div><strong>Customer:</strong> <?php echo $booking->customer->full_name; ?></div>
            <div><strong>Phone:</strong> <?php echo $booking->customer->mobile_number; ?></div>
            <div><strong>Booking:</strong> #<?php echo $booking->id; ?></div>
            <div><strong>Room:</strong> <?php echo $show_rooms = $this->Common->show_rooms($booking->id); ?></div>
            <div><strong>Stay:</strong> <?php echo date("M d, Y",strtotime($booking->check_in_date)); ?> - <?php echo date("M d, Y",strtotime($booking->check_out_date)); ?></div>
        </div>
        
        <!-- Payment Details -->
        <div class="payment-details">
            <div class="section-title">PAYMENT DETAILS</div>
			<?php echo $this->Common->verify_booking_payment($booking->id); ?>
            <!-- <div><strong>Method:</strong> CASH</div>
            <div><strong>Type:</strong> Room Charges</div>
            <div><strong>Notes:</strong> Payment via guest details modal using cash</div> -->
        </div>

		<?php
		$final_tally_summery = $this->Common->final_tally_summery($booking->id); 
		$tally_summery = explode("@",$final_tally_summery);
		$amount_payble = $tally_summery[0];
		$amount_received = $tally_summery[1];
		$outstanding = $tally_summery[2];
		?>
        
        <!-- Amount Section -->
        <div class="amount-section">
            <div class="amount-line total-line">
                <span>TOTAL PAID:</span>
                <span><?php echo $site_general_settings->currency; ?><?php echo round($amount_received) ?></span>
            </div>
        </div>
        
        <!-- Bill Summary -->
        <div class="amount-section">
            <div style="text-align: center; font-weight: bold; margin-bottom: 4px;">BILL SUMMARY</div>
            <div class="amount-line">
                <span>Total Bill Amount:</span>
                <span><?php echo $site_general_settings->currency; ?><?php echo round($amount_payble) ?></span>
            </div>
            <div class="amount-line">
                <span>Total Paid:</span>
                <span><?php echo $site_general_settings->currency; ?><?php echo round($amount_received) ?></span>
            </div>
            <div class="amount-line">
                <span>Outstanding:</span>
                <span><?php echo $site_general_settings->currency; ?><?php echo round($outstanding) ?></span>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="receipt-footer">
            <div style="margin-bottom: 4px;">Thank you for your payment!</div>
            <div style="margin-bottom: 8px;">Receipt #: PAY-<?php echo date("Ymd",strtotime($booking->booking_date)) ?>-<?php echo $booking->id; ?></div>
            <div style="font-size: 8px; color: #999;">For queries, contact front desk</div>
        </div>
        
        <!-- Print Button (hidden when printing) -->
        <div class="print-btn" style="text-align: center; margin-top: 20px;">
            <button onclick="window.print()" style="background: #28a745; color: white !important; padding: 15px 30px; border: none; border-radius: 8px; font-size: 16px; font-weight: bold; cursor: pointer; box-shadow: 0 4px 15px rgba(0,0,0,0.2);" onmouseover="this.style.background='#218838'" onmouseout="this.style.background='#28a745'">
                🖨️ PRINT RECEIPT
            </button>
            <div style="margin-top: 10px; font-size: 12px; color: #666;">
                You can also use Ctrl+P (Windows) or Cmd+P (Mac) to print
            </div>
        </div>
    </div>

    <script>
        // Add keyboard shortcut for printing
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
                e.preventDefault();
                window.print();
            }
        });

        // Optimize for thermal printing
        window.addEventListener('beforeprint', function() {
            // Add thermal print optimization class
            document.body.classList.add('thermal-print');
        });

        window.addEventListener('afterprint', function() {
            // Remove thermal print optimization class
            document.body.classList.remove('thermal-print');
        });
    </script>
</body>
</html>  