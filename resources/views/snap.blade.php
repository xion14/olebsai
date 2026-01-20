<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Midtrans</title>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" 
        data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

 
    <button id="pay-button">Bayar Sekarang</button>

    <script>
        $(document).ready(function() {
            $('#pay-button').click(function(e) {
                e.preventDefault();
                var token = "f2afab7c-43cc-451b-add9-a968191587ec"
                window.snap.pay(token, {
                    
                });
            });
        });
    </script>

</body>
</html>
