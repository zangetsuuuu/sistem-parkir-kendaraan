<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biaya Parkir</title>
    <style>
        /* CSS untuk popup */
        .popup {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1;
        }
        
        .popup-inner {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
            max-width: 100%;
            max-height: 100%;
            overflow-y: auto;
        }
        
        /* CSS untuk tombol OK */
        .btn-ok {
            background-color: #4CAF50;
            color: #fff;
            border: none;
            width: 100%;
            margin-top: 16px;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
        }
        
        .btn-ok:hover {
            background-color: #3e8e41;
        }
    </style>
</head>
<body>
    <div class="popup">
        <div class="popup-inner">
            <h4>Biaya Parkir</h4><hr>
            <p style="font-size: 16px;">Rp <?= number_format(round($biayaParkir), 0, ',', '.'); ?></p>
            <button class="btn-ok" onclick="closePopup()">OK</button>
        </div>
    </div>

    <script>
    function closePopup() {
        document.querySelector('.popup').style.display = 'none';
    }
    </script>
</body>
</html>
