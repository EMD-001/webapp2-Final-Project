<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            
        }

        .video-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        #postLists {
            list-style: none;
            padding: 0;
            text-align: center;
        }
        #postLists li {
            background-color: #f9f9f9;
            margin: 10px 0;
            padding: 15px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        #postLists li:nth-child(odd) {
            background-color: #FFB6C1;
        }

        #postLists li:hover {
            background-color: #fff;
        }
        #postLists li a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
            display: block;
        }
        .error {
            color: red;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    
    <video class="video-bg" autoplay muted loop>
        <source src="bg.mp4" type="video/mp4">
    </video>
    <div class="container">
        <h1>Posts Page</h1>
        <ul id="postLists">
            <?php

            require 'config.php';

            if (!isset($_SESSION['user_id'])) {
                header("Location: index.php");
                exit;
            }

            $dsn = "mysql:host=$host;dbname=$db;charset=UTF8";
            $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

            try {
                $pdo = new PDO($dsn, $user, $password, $options);

                if ($pdo) {
                    $user_id = $_SESSION['user_id'];

                    $query = "SELECT * FROM `posts` WHERE user_id = :id";
                    $statement = $pdo->prepare($query);
                    $statement->execute([':id' => $user_id]);

                    /*
                     * First approach using fetchAll and foreach loop
                     */
                    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($rows as $row) {
                        // echo '<li data-id="' . $row['id'] . '">' . $row['title'] . '</li>';
                        echo '<li><a href="item-details.php?id=' . $row['id'] . '">' . $row['title'] . '</li>';
                    }

                    /*
                     * Second approach using fetch and while loop
                     */
                    // while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                    // echo '<li data-id="' . $row['id'] . '">' . $row['title'] . '</li>';
                    // echo '<li><a href="post.php?id=' . $row['id'] . '">' . $row['title'] . '</li>';
                    // }
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            ?>
        </ul>
    </div>
</body>
<script>
    // Redirect to post.php with the ID of the clicked post
    // document.addEventListener("DOMContentLoaded", function () {
    //     const postLists = document.getElementById("postLists");
    //     postLists.addEventListener("click", function (event) {
    //         if (event.target.tagName === "LI") {
    //             const id = event.target.getAttribute("data-id");
    //             window.location.href = `post.php?id=${id}`;
    //         }
    //     });
    // });
</script>

</html>