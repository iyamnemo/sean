<?php 
// Guard
require_once '_guards.php';
Guard::guestOnly();
?>

  <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luis Galapon</title>
    <style>
       
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #74ebd5, #acb6e5);
            color: #333;
            overflow: hidden; 
        }

      
        h1 {
            position: absolute;
            top: 20px;
            left: -300px;
            font-size: 36px;
            background: linear-gradient(135deg, #6a0dad, #000000, #1e3c72); 
            -webkit-background-clip: text;
            color: transparent;
            animation: moveH1 5s ease-in-out infinite;
        }


        @keyframes moveH1 {
            0% {
                left: -300px;
            }
            50% {
                left: 50%;
                transform: translateX(-50%);
            }
            100% {
                left: 100vw;
            }
        }

       
        .login.card {
            width: 360px;
            padding: 20px;
            border-radius: 15px;
            background: rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            animation: fadeIn 1.5s ease-out;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: scale(0.8);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        
        .card-content {
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            color: #fff;
        }

        input {
            width: 94%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            outline: none;
            background: rgba(255, 255, 255, 0.5);
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        input:focus {
            border-color: #74ebd5;
            box-shadow: 0 0 5px #74ebd5;
            background: white;
        }

        
        button {
            padding: 10px 15px;
            background-color: #74ebd5;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #4cb5ab;
        }

     
        .mt-16 {
            margin-top: 16px;
        }

        .flex {
            display: flex;
        }

        .justify-end {
            justify-content: flex-end;
        }
    </style>
</head>
<body>

    <h1>POS - SAD ACTIVITY</h1>

    <div class="login card">
        <div class="card-content">
            <form method="POST" action="function/login_controller.php">
                <?php displayFlashMessage('login') ?>

                <div class="form-control">
                    <label>Email</label>
                    <input 
                        type="text" 
                        name="email" 
                        placeholder="Enter your email here" 
                        required="true" 
                    />
                </div>

                <div class="form-control mt-16">
                    <label>Password</label>
                    <input 
                        type="password" 
                        name="password" 
                        placeholder="Enter your password here" 
                        required="true" 
                    />
                </div>

                <div class="mt-16 flex justify-end">
                    <button class="btn btn-primary" type="submit">LOG IN</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
