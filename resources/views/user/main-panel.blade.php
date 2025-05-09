<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NCHE Dashboard</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: Arial, sans-serif;
        }
        .cover-photo {
    background: url('{{ asset('assets/images/cover.jpg') }}') no-repeat center center;
    background-size: cover; 
    background-position: center center; /* Adjust the image's focus */
    height: 300px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.7);
    font-size: 2rem;
    font-weight: bold;
    text-align: center;
    padding: 0 1rem;
}

        .stats-container {
            margin-top: -60px;
            display: flex;
            justify-content: center;
            gap: 2rem;
            flex-wrap: wrap;
            padding: 2rem 1rem;
        }
        .stat-box {
            background-color: #dd8027;
            color: white;
            padding: 2rem;
            border-radius: 1.5rem;
            width: 100%;
            max-width: 300px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            transition: transform 0.2s;
            text-align: center;
        }
        .stat-box:hover {
            transform: scale(1.05);
        }
        .stat-title {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
        }
        .stat-count {
            font-size: 2.5rem;
            font-weight: bold;
            color: #52074f;
        }
    </style>
</head>
<body>
    <div class="cover-photo">
        Welcome {{ Auth::user()->name }}
    </div>

    <div class="stats-container">
        <div class="stat-box">
            <div class="stat-title">Submitted Applications</div>
            <div class="stat-count">2</div>
        </div>
        <div class="stat-box">
            <div class="stat-title">Verified Applications</div>
            <div class="stat-count">1</div>
        </div>
        <div class="stat-box">
            <div class="stat-title">Application Status</div>
            <div class="stat-count">Active</div>
        </div>
    </div>
</body>
</html>
