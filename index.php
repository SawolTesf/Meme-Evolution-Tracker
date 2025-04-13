<?php
       
?>
<!DOCTYPE html>
<html lang ='en'>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel = "stylesheet" href = "style.css">
    <script src="https://kit.fontawesome.com/d889c79a49.js" crossorigin="anonymous"></script>
    <title>Meme Evolution Tracker</title>
</head>
<body>
    <header class = "Header">
        <h1 class = "Header_left">
            Meme Evolution Tracker 😎
        </h1>
        <ul class = "Header_right">
            <li><a href = "index.php">Search Page</a></li>
            <li><a href = "upload.php">Upload Page</a></li>
        </ul>
        
    </header>
    <main>
    <h2>Search Memes</h2><br>
        <form method="get" action="search.php"><br>
        <input type="text" name="keyword" placeholder="Enter keyword" ><br>
        <button type = "submit">Search</button>
        <div class = "meme_card">
        <h2>Meme Name:</h2>
        <p>Tralalero Tralala</p><br>
        <h2>First Appearance Data</h2>
        <p>04/01/2025</p><br>
        <h2>Description:</h2>
        <p>"Tralalero Tralala" is a viral meme that emerged in early 2025, originating from TikTok. It features a nonsensical Italian phrase, often accompanied by absurd AI-generated images. One of the most iconic visuals associated with this meme is a shark equipped with Nike sneakers, humorously depicted walking on land instead of swimming.​

The meme is part of a broader trend known as "Italian Brainrot", characterized by surreal and intentionally low-quality content that parodies traditional memes. These memes often include bizarre characters, such as animals with human traits, and are set against chaotic backdrops with exaggerated sound effects.​

The "shark with shoes" specifically represents a character named Tralalero Tralala, described as a unique shark with three legs—two replacing its side fins and a third at the end of its tail. Instead of swimming like other sharks, it strides across the ocean floor with surprising agility. Adding to its uniqueness, Tralalero sports a pair of stylish blue Nike shoes, giving it both grip and undeniable swagger as it moves through the deep. </p><br>
        <h2>Link to it:</h2>
        <a href ="https://www.youtube.com/watch?v=3BUoNJSPujU">
            <i class="fa-brands fa-youtube"></i>
        </a><br>
        <h2>Image of the meme:</h2>
<img src = "Tralalelo TraLaLa.jpg"><br>
        </div>
        
        
        
    </main>
    <footer class = "Footer">
    <div class = "info">
            <h3 class = "info_topic">Team Members</h3>
            <ul class = "members">
                <li>Zainuddin Mohammed</li>
                <li>Yifan Ren</li>
                <li>Se Pdrer</li>
                <li>Saol Tesfaghebriel</li>
                <li>Junaid Bashi</li>
            </ul>

        </div>
    </footer>
    
    <form action="index.php" method="post">
        
    </form><br>
</body>
</html>

<?php
       
?>