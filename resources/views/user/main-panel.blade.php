<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NCHE Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
    background-position: center center;
    height: 300px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 0 1rem;
}
.large-check {
  color: white;
  font-size: 5rem;
  padding-right: 8px;
}


.tinted-text {
    font-size: 2.5rem;
    font-weight: bold;
    font-family: 'Inter', sans-serif;
    text-align: center;

    /* Brighter gradient tint */
    background: linear-gradient(45deg, #ffffff, #ffe28a, #ff8a00);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    -webkit-text-fill-color: transparent;

    /* Optional: glow effect */
    text-shadow: 0 0 6px rgba(255, 255, 255, 0.6);
    position: relative;
    top:90px;
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
            background-color:#dd8027 ;
            color: #52074f;
            font-weight: bold;
            padding: 2rem;
            border-radius: 1.5rem;
            width: 100%;
            max-width: 300px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            transition: transform 0.2s;
            text-align: center;
        
      margin-top: 80px;
      
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
            color: white;
        }
    </style>
</head>
<body>
    <div class="cover-photo">
      <span class="tinted-text">Welcome {{ Auth::user()->name }}</span>
    </div>

    <div class="stats-container">
  <div class="stat-box">
    <div class="stat-title">Submitted Applications</div>
    <i class="fas fa-file-upload" style="font-size: 5rem; color: white;"></i>

    <div class="stat-count">2</div>
  </div>

  <div class="stat-box section-title">
    <div class="stat-title">
      
        Verified Applications <i class="fas fa-check-circle large-check"style="color: white;"  style="font-size: 2.0 rem;"></i>
      
    </div>
    <div class="stat-count">1</div>
  </div>

  <div class="stat-box">
    <div class="stat-title">Application Status</div>
   
<i class="fas fa-play" style="font-size: 4rem; color: white;"></i>
 <div class="stat-count">Active</div>
  </div>
</div>

</body>
</html>
<style>

   

</style>