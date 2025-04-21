<?php
require 'db.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

function fetchGoogleTrendsData($query, $startDate, $endDate) {
    $apiKey = ''; // Replace with your actual SerpAPI key
    $params = [
        'engine' => 'google_trends',
        'q' => $query,
        'geo' => 'US',
        'date' => "$startDate $endDate",
        'data_type' => 'TIMESERIES',
        'api_key' => $apiKey
    ];
    $url = 'https://serpapi.com/search?' . http_build_query($params);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}

$id = $_GET['id'] ?? null;
if (!$id) die("No meme ID specified.");

$stmt = $conn->prepare("SELECT * FROM MEME WHERE meme_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$meme = $result->fetch_assoc();
if (!$meme) die("Meme not found.");

$startTimestamp = strtotime($meme['first_appearance']);
$oneYearLater = strtotime('+1 year', $startTimestamp);
$now = time();

$startDate = date('Y-m-d', $startTimestamp);
$endDate = ($oneYearLater > $now) ? date('Y-m-d', $now) : date('Y-m-d', $oneYearLater);

$link_stmt = $conn->prepare("SELECT link, description FROM MEME_REFERENCE_LINK WHERE meme_id = ?");
$link_stmt->bind_param("i", $id);
$link_stmt->execute();
$reference_links = $link_stmt->get_result();

$trends = fetchGoogleTrendsData($meme['name'], $startDate, $endDate);

$trend_labels = [];
$trend_values = [];

if (!empty($trends['interest_over_time']['timeline_data'])) {
    foreach ($trends['interest_over_time']['timeline_data'] as $point) {
        if (isset($point['values'][0]['extracted_value'])) {
            $trend_labels[] = $point['date'];
            $trend_values[] = $point['values'][0]['extracted_value'];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($meme['name']) ?> – Meme Wiki</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #0f0f0f, #1a1a1a);
            color: #f5f5f5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .content-wrapper {
            display: flex;
            justify-content: center;
            padding: 8rem 1rem 2rem;
            flex: 1;
        }

        .main {
            width: 100%;
            max-width: 850px;
        }

        .meme-title {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: #fe2c55;
        }

        .card {
            background: #1c1c1e;
            padding: 2rem;
            border-left: 6px solid #25f4ee;
            border-radius: 6px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            margin-bottom: 2rem;
        }

        .label {
            font-weight: bold;
            display: inline-block;
            width: 160px;
            color: #25f4ee;
        }

        .value {
            color: #f5f5f5;
        }

        p { margin-bottom: 1rem; }

        a.back-link {
            color: #25f4ee;
            text-decoration: none;
            margin-top: 1.5rem;
            display: inline-block;
            font-weight: bold;
        }

        a.back-link:hover {
            text-decoration: underline;
        }

        .ref-toggle {
            background: #fe2c55;
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: bold;
        }

        #linkList {
            display: none;
            margin-top: 1rem;
            list-style: none;
            padding-left: 0;
        }

        #linkList li {
            margin-bottom: 0.8rem;
        }

        #linkList a {
            color: #25f4ee;
            text-decoration: none;
        }

        #linkList a:hover {
            text-decoration: underline;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="content-wrapper">
    <div class="main">
        <h2 class="meme-title"><?= htmlspecialchars($meme['name']) ?></h2>

        <div class="card">
            <p><span class="label">Original Platform:</span> <span class="value"><?= htmlspecialchars($meme['origin_platform']) ?></span></p>
            <p><span class="label">First Appearance:</span> <span class="value"><?= htmlspecialchars($meme['first_appearance']) ?></span></p>
            <p><span class="label">Description:</span><br><span class="value"><?= nl2br(htmlspecialchars($meme['description'])) ?></span></p>
        </div>

        <div class="card">
            <h3 style="margin-bottom: 1rem;">
                📊 Google Trends (<?= htmlspecialchars($startDate) ?> to <?= htmlspecialchars($endDate) ?>)
            </h3>

            <canvas id="trendChart" height="100"></canvas>
        </div>

        <script>
            const ctx = document.getElementById('trendChart').getContext('2d');
            const trendChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: <?= json_encode($trend_labels) ?>,
                    datasets: [{
                        label: 'Trend Score',
                        data: <?= json_encode($trend_values) ?>,
                        borderColor: '#25f4ee',
                        backgroundColor: 'rgba(37, 244, 238, 0.1)',
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: '#f5f5f5'
                            }
                        },
                        x: {
                            ticks: {
                                color: '#f5f5f5',
                                maxRotation: 45,
                                minRotation: 45
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                color: '#f5f5f5'
                            }
                        }
                    }
                }
            });
        </script>


        <div class="card">
            <button class="ref-toggle" onclick="toggleLinks()">🔗 View Reference Links</button>
            <ul id="linkList">
                <?php while ($row = $reference_links->fetch_assoc()): ?>
                    <li>
                        <a href="<?= htmlspecialchars($row['link']) ?>" target="_blank">
                            <?= htmlspecialchars($row['description'] ?: $row['link']) ?>
                        </a>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>

        <?php if (!empty($_SESSION['is_admin'])): ?>
            <form action="delete.php" method="GET" onsubmit="return confirm('Are you sure you want to delete this meme?');" style="margin-top: 1rem;">
                <input type="hidden" name="id" value="<?= $meme['meme_id'] ?>">
                <button type="submit" style="background: #ff4c4c; color: white; padding: 0.5rem 1rem; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">
                    🗑️ Delete Meme
                </button>
            </form>
        <?php endif; ?>
        <?php if (!empty($_SESSION['is_admin'])): ?>
            <form action="edit_meme.php" method="GET" style="margin-top: 1rem;">
                <input type="hidden" name="id" value="<?= $meme['meme_id'] ?>">
                <button type="submit" style="background: #25f4ee; color: black; padding: 0.5rem 1rem; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">
                    ✏️ Edit Meme
                </button>
            </form>
        <?php endif; ?>


        <a class="back-link" href="index.php">&larr; Back to home</a>
    </div>
</div>

<script>
    function toggleLinks() {
        const list = document.getElementById('linkList');
        list.style.display = list.style.display === 'none' ? 'block' : 'none';
    }
</script>

</body>
</html>
