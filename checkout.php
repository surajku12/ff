<?php
$page_title = "Checkout | FASHIOFY";
include 'includes/header.php';
?>

<div class="checkout-hero" style="background: #111; color: white; padding: 60px 0; text-align: center;">
    <h1 style="font-family: 'Playfair Display', serif; font-size: 3rem; margin-bottom: 10px;">Secure Checkout</h1>
    <p style="opacity: 0.8; font-size: 1rem;">Review your details and complete your purchase securely</p>
</div>

<main class="checkout-wrapper" style="max-width: 1200px; margin: 60px auto; padding: 0 20px; display: grid; grid-template-columns: 1fr 400px; gap: 60px;">
    <form id="checkout-form" class="checkout-container">
        <!-- Personal Information Section -->
        <div class="form-section" style="margin-bottom: 50px;">
            <div class="form-section-title" style="font-size: 1.3rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 30px; border-bottom: 2px solid #111; padding-bottom: 15px;">1. Personal Information</div>
            <div class="form-row full" style="margin-bottom: 20px;">
                <div class="form-group" style="display: flex; flex-direction: column; gap: 8px;">
                    <label for="name" style="font-weight: 700; font-size: 0.8rem; text-transform: uppercase; color: #555;">Full Name <span style="color: #e74c3c;">*</span></label>
                    <input type="text" id="name" name="name" required placeholder="Full Name" style="padding: 15px; border: 2px solid #eee; border-radius: 8px; font-size: 1rem; transition: border-color 0.3s ease;">
                    <div class="form-error" id="name-error"></div>
                </div>
            </div>
            <div class="form-row full" style="margin-bottom: 20px;">
                <div class="form-group" style="display: flex; flex-direction: column; gap: 8px;">
                    <label for="email" style="font-weight: 700; font-size: 0.8rem; text-transform: uppercase; color: #555;">Email Address <span style="color: #e74c3c;">*</span></label>
                    <input type="email" id="email" name="email" required placeholder="your@email.com" style="padding: 15px; border: 2px solid #eee; border-radius: 8px; font-size: 1rem;">
                    <div class="form-error" id="email-error"></div>
                </div>
            </div>
            <div class="form-row full" style="margin-bottom: 20px;">
                <div class="form-group" style="display: flex; flex-direction: column; gap: 8px;">
                    <label for="mobile" style="font-weight: 700; font-size: 0.8rem; text-transform: uppercase; color: #555;">Mobile Number <span style="color: #e74c3c;">*</span></label>
                    <input type="tel" id="mobile" name="mobile" required placeholder="98765 43210" style="padding: 15px; border: 2px solid #eee; border-radius: 8px; font-size: 1rem;">
                    <div class="form-error" id="mobile-error"></div>
                </div>
            </div>
        </div>

        <!-- Delivery Address Section -->
        <div class="form-section" style="margin-bottom: 50px;">
            <div class="form-section-title" style="font-size: 1.3rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 30px; border-bottom: 2px solid #111; padding-bottom: 15px;">2. Delivery Address</div>
            <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div class="form-group" style="display: flex; flex-direction: column; gap: 8px;">
                    <label for="pincode" style="font-weight: 700; font-size: 0.8rem; text-transform: uppercase; color: #555;">Pincode <span style="color: #e74c3c;">*</span></label>
                    <input type="text" id="pincode" name="pincode" required maxlength="6" pattern="\d{6}" placeholder="110001" style="padding: 15px; border: 2px solid #eee; border-radius: 8px; font-size: 1rem;">
                    <div class="form-error" id="pincode-error"></div>
                </div>
                <div class="form-group" style="display: flex; flex-direction: column; gap: 8px;">
                    <label for="street" style="font-weight: 700; font-size: 0.8rem; text-transform: uppercase; color: #555;">Street / Area <span style="color: #e74c3c;">*</span></label>
                    <input type="text" id="street" name="street" required placeholder="Main Road" style="padding: 15px; border: 2px solid #eee; border-radius: 8px; font-size: 1rem;">
                </div>
            </div>
            <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div class="form-group" style="display: flex; flex-direction: column; gap: 8px;">
                    <label for="city" style="font-weight: 700; font-size: 0.8rem; text-transform: uppercase; color: #555;">City <span style="color: #e74c3c;">*</span></label>
                    <input type="text" id="city" name="city" required placeholder="City" style="padding: 15px; border: 2px solid #eee; border-radius: 8px; font-size: 1rem;">
                </div>
                <div class="form-group" style="display: flex; flex-direction: column; gap: 8px;">
                    <label for="state" style="font-weight: 700; font-size: 0.8rem; text-transform: uppercase; color: #555;">State <span style="color: #e74c3c;">*</span></label>
                    <input type="text" id="state" name="state" required placeholder="State" style="padding: 15px; border: 2px solid #eee; border-radius: 8px; font-size: 1rem;">
                </div>
            </div>
        </div>

        <!-- Payment Method Section -->
        <div class="form-section">
            <div class="form-section-title" style="font-size: 1.3rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 30px; border-bottom: 2px solid #111; padding-bottom: 15px;">3. Payment Method</div>
            <div class="form-row full">
                <div class="form-group" style="display: flex; flex-direction: column; gap: 8px;">
                    <label for="payment" style="font-weight: 700; font-size: 0.8rem; text-transform: uppercase; color: #555;">Choose Payment Method <span style="color: #e74c3c;">*</span></label>
                    <select id="payment" name="payment" required style="padding: 15px; border: 2px solid #eee; border-radius: 8px; font-size: 1rem; background: #fff; cursor: pointer;">
                        <option value="">Select an option</option>
                        <option value="credit-card">Credit Card</option>
                        <option value="debit-card">Debit Card</option>
                        <option value="upi">UPI / Scanner</option>
                        <option value="netbanking">Net Banking</option>
                        <option value="cod">Cash on Delivery</option>
                    </select>
                </div>
            </div>

            <!-- Card Details Form (Credit/Debit) -->
            <div id="card-details-group" style="display: none; margin-top: 30px; padding: 25px; background: #fafafa; border-radius: 8px; border: 1px solid #eee;">
                <h4 style="margin: 0 0 20px 0; font-weight: 700; text-transform: uppercase; font-size: 0.9rem;">Card Details</h4>
                <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div class="form-group" style="display: flex; flex-direction: column; gap: 8px;">
                        <label for="card_name" style="font-weight: 700; font-size: 0.75rem; text-transform: uppercase; color: #555;">Cardholder Name <span style="color: #e74c3c;">*</span></label>
                        <input type="text" id="card_name" name="card_name" placeholder="John Doe" style="padding: 12px; border: 1px solid #ddd; border-radius: 4px; font-size: 0.9rem;">
                    </div>
                    <div class="form-group" style="display: flex; flex-direction: column; gap: 8px;">
                        <label for="card_number" style="font-weight: 700; font-size: 0.75rem; text-transform: uppercase; color: #555;">Card Number <span style="color: #e74c3c;">*</span></label>
                        <input type="text" id="card_number" name="card_number" placeholder="1234 5678 9012 3456" maxlength="19" style="padding: 12px; border: 1px solid #ddd; border-radius: 4px; font-size: 0.9rem;">
                    </div>
                </div>
                <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
                    <div class="form-group" style="display: flex; flex-direction: column; gap: 8px;">
                        <label for="card_month" style="font-weight: 700; font-size: 0.75rem; text-transform: uppercase; color: #555;">Month <span style="color: #e74c3c;">*</span></label>
                        <input type="text" id="card_month" name="card_month" placeholder="MM" maxlength="2" style="padding: 12px; border: 1px solid #ddd; border-radius: 4px; font-size: 0.9rem;">
                    </div>
                    <div class="form-group" style="display: flex; flex-direction: column; gap: 8px;">
                        <label for="card_year" style="font-weight: 700; font-size: 0.75rem; text-transform: uppercase; color: #555;">Year <span style="color: #e74c3c;">*</span></label>
                        <input type="text" id="card_year" name="card_year" placeholder="YY" maxlength="2" style="padding: 12px; border: 1px solid #ddd; border-radius: 4px; font-size: 0.9rem;">
                    </div>
                    <div class="form-group" style="display: flex; flex-direction: column; gap: 8px;">
                        <label for="card_cvv" style="font-weight: 700; font-size: 0.75rem; text-transform: uppercase; color: #555;">CVV <span style="color: #e74c3c;">*</span></label>
                        <input type="text" id="card_cvv" name="card_cvv" placeholder="123" maxlength="4" style="padding: 12px; border: 1px solid #ddd; border-radius: 4px; font-size: 0.9rem;">
                    </div>
                </div>
            </div>

            <!-- UPI Details Form -->
            <div id="upi-details-group" style="display: none; margin-top: 30px; padding: 25px; background: #fafafa; border-radius: 8px; border: 1px solid #eee;">
                <h4 style="margin: 0 0 20px 0; font-weight: 700; text-transform: uppercase; font-size: 0.9rem;">UPI Payment</h4>
                <div class="form-group" style="display: flex; flex-direction: column; gap: 8px; margin-bottom: 20px;">
                    <label for="upi_id" style="font-weight: 700; font-size: 0.75rem; text-transform: uppercase; color: #555;">Your UPI ID <span style="color: #e74c3c;">*</span></label>
                    <input type="text" id="upi_id" name="upi_id" placeholder="yourname@upi" style="padding: 12px; border: 1px solid #ddd; border-radius: 4px; font-size: 0.9rem;">
                </div>
                <div style="text-align: center; padding: 20px; background: white; border-radius: 8px; border: 2px dashed #ddd;">
                    <p style="margin: 0 0 15px 0; font-weight: 700; color: #333;">Scan with Your UPI App</p>
                    <div id="upi-qr-code" style="display: flex; justify-content: center; align-items: center; min-height: 200px; background: #f9f9f9; border-radius: 4px;">
                        <p style="color: #999;">QR code will appear here</p>
                    </div>
                </div>
            </div>

            <!-- NetBanking Details -->
            <div id="netbanking-details-group" style="display: none; margin-top: 30px; padding: 20px; background: #fafafa; border-radius: 8px;">
                <p style="color: #666; margin: 0;">You will be redirected to your bank's portal. No additional information needed here.</p>
            </div>

            <!-- COD Info -->
            <div id="cod-details-group" style="display: none; margin-top: 30px; padding: 20px; background: #e8f5e9; border-radius: 8px; border-left: 4px solid #27ae60;">
                <p style="color: #27ae60; margin: 0; font-weight: 700;">✓ Cash on Delivery - Pay when you receive your order</p>
            </div>
        </div>

        <button type="submit" class="btn-place-order" style="width: 100%; padding: 22px; background: #111; color: white; border: none; border-radius: 8px; font-weight: 800; text-transform: uppercase; margin-top: 50px; cursor: pointer; letter-spacing: 2px; transition: all 0.3s ease;">Complete Purchase</button>
    </form>

    <aside class="order-summary" style="background: #fcfcfc; border: 1px solid #eee; padding: 40px; border-radius: 12px; height: fit-content; position: sticky; top: 100px;">
        <h3 style="font-size: 1.4rem; font-weight: 800; margin-bottom: 30px; text-transform: uppercase; letter-spacing: 1px;">Order Summary</h3>
        <div id="summary-items" style="margin-bottom: 30px;">
            <!-- items injected by script.js -->
        </div>
        <div class="order-total" style="border-top: 2px solid #111; padding-top: 25px; display: flex; justify-content: space-between; align-items: center;">
            <span style="font-size: 1.2rem; font-weight: 800; text-transform: uppercase;">Total to Pay</span>
            <span id="summary-total" style="font-size: 1.8rem; font-weight: 800; color: #111;">₹0.00</span>
        </div>
        
        <div style="margin-top: 40px; border-top: 1px solid #eee; padding-top: 30px; font-size: 0.8rem; color: #888; text-align: center;">
            🔒 Secure 256-bit SSL encrypted checkout
        </div>
    </aside>
</main>

<div style="margin-bottom: 80px;"></div>

<?php include 'includes/footer.php'; ?>
