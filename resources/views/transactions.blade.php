<!-- resources/views/transactions.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactions</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2>Deposit</h2>
                <form action="{{ route('deposit') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="number" name="amount" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Deposit</button>
                </form>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-6 offset-md-3">
                <h2>Withdraw</h2>
                <form action="{{ route('withdraw') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="number" name="amount" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Withdraw</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
