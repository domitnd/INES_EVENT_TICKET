<?php 
require_once 'config/database.php';

// Get event ID from URL
$id = $_GET['id'] ?? 0;

if (!$id) {
    header('Location: index.php');
    exit;
}

// Get event details
$stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
$stmt->execute([$id]);
$event = $stmt->fetch();

// If event not found, go back to homepage
if (!$event) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($event['title']); ?> - INES Event Hub</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #628d66 0%, #60a165 100%);
            min-height: 100vh;
            padding: 20px;
        }


        
        
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .back-link {
            display: inline-block;
            color: white;
            text-decoration: none;
            margin-bottom: 20px;
            padding: 10px 20px;
            background: rgba(255,255,255,0.2);
            border-radius: 8px;
        }
        
        .event-detail {
            background: white;
            border-radius: 15px;
            padding: 30px;
        }
        
        .event-detail h1 {
            color: #333;
            margin-bottom: 20px;
        }
        
        .event-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }
        
        .event-info p {
            margin-bottom: 10px;
            color: #666;
        }
        
        .price-tag {
            font-size: 28px;
            color: #667eea;
            font-weight: bold;
            margin-top: 10px;
        }
        
        .event-description {
            margin: 30px 0;
        }
        
        .event-description h3 {
            margin-bottom: 15px;
        }
        
        .event-description p {
            color: #666;
            line-height: 1.6;
        }
        
        .buy-form {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #e0e0e0;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }
        
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
        }
        
        .btn-large {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #64a76f, #afa8b6);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
        }
        
        @media (max-width: 768px) {
            .event-detail { padding: 20px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="index.php" class="back-link">← Back to Events</a>
        
        <div class="event-detail">
            <h1><?php echo htmlspecialchars($event['title']); ?></h1>
            
            <div class="event-info">
                <p><strong>📅 Date:</strong> <?php echo date('F j, Y', strtotime($event['event_date'])); ?></p>
                <p><strong>⏰ Time:</strong> <?php echo date('g:i A', strtotime($event['event_time'])); ?></p>
                <p><strong>📍 Venue:</strong> <?php echo htmlspecialchars($event['venue']); ?></p>
                <p class="price-tag">RWF <?php echo number_format($event['price']); ?></p>
            </div>
            
            <div class="event-description">
                <h3>About this event</h3>
                <p><?php echo nl2br(htmlspecialchars($event['description'] ?: 'No description available.')); ?></p>
            </div>
            
            <form action="checkout.php" method="POST" class="buy-form">
                <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>">
                <div class="form-group">
                    <label>Number of Tickets:</label>
                    <input type="number" name="quantity" min="1" max="10" value="1" required>
                </div>
                <button type="submit" class="btn-large">Buy Now</button>
            </form>
        </div>
    </div>
</body>
</html>