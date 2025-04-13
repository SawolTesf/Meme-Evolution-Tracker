<?php
       
?>
<!DOCTYPE html>
<html lang ='en'>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel = "stylesheet" href = "style.css">
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
        <div><h1>📤 Upload Meme</h1></div>
        <div class="upload_page">
  <h2>Submit a New Meme</h2>

  <form action="upload.php" method="post">
    <!-- Meme Core Info -->
    <fieldset>
      <legend>Meme Info</legend>

      <label for="meme_name">Meme Name:</label><br>
      <input type="text" id="meme_name" name="meme_name" required><br><br>

      <label for="origin_platform">Origin Platform:</label><br>
      <input type="text" id="origin_platform" name="origin_platform"><br><br>

      <label for="first_appearance">First Appearance Date:</label><br>
      <input type="date" id="first_appearance" name="first_appearance"><br><br>

      <label for="description">Description:</label><br>
      <textarea id="description" name="description" rows="4" cols="50"></textarea><br><br>

      <label for="image_link">Image or Video Link:</label><br>
      <input type="text" id="image_link" name="image_link" placeholder="https://..."><br><br>
    </fieldset>
    <br>

    <!-- Meme Variation Info -->
    <fieldset>
      <legend>First Variation</legend>

      <label for="variation_type">Variation Type:</label><br>
      <input type="text" id="variation_type" name="variation_type" placeholder="e.g., Text, Image, GIF"><br><br>

      <label for="variation_date">Variation Date:</label><br>
      <input type="date" id="variation_date" name="variation_date"><br><br>

      <label for="platform_spread">Platform Where It Spread:</label><br>
      <input type="text" id="platform_spread" name="platform_spread"><br><br>
    </fieldset>
    <br>

    <button type="submit">Submit Meme</button><br><br>
  </form>
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