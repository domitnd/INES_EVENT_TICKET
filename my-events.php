<?php 
require_once 'config/database.php';

// Check if organizer is logged in
if (!isset($_SESSION['admin_id']) || $_SESSION['admin_type'] != 'organizer') {
    header('Location: admin-login.php');
    exit;
}

$organizer_id = $_SESSION['admin_id'];

// Get events
$stmt = $pdo->prepare("
    SELECT e.*, 
           (SELECT COUNT(*) FROM tickets WHERE event_id = e.id) as tickets_sold,
           COALESCE((SELECT SUM(total_amount) FROM tickets WHERE event_id = e.id), 0) as revenue
    FROM events e
    ORDER BY e.event_date DESC
");
$stmt->execute();
$events = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Events</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 20px;
            color: white;
            background: linear-gradient(135deg, #764ba2, #9f7aea);
        }
        
        .role-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 10px;
            background: rgba(255,255,255,0.2);
            color: white;
        }
        
        .logout-link {
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            background: rgba(255,255,255,0.2);
            border-radius: 8px;
            transition: background 0.3s;
        }
        
        .logout-link:hover {
            background: rgba(255,255,255,0.3);
        }
        
        .event-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .event-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        
        .event-card-header {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 15px;
        }
        
        .event-card-header h3 {
            margin-bottom: 5px;
            font-size: 18px;
        }
        
        .event-card-body {
            padding: 15px;
        }
        
        .event-details p {
            margin-bottom: 5px;
            color: #666;
        }
        
        .event-stats {
            display: flex;
            justify-content: space-around;
            margin: 15px 0;
            padding: 10px 0;
            border-top: 1px solid #e0e0e0;
            border-bottom: 1px solid #e0e0e0;
            background: #f8f9fa;
            border-radius: 8px;
        }
        
        .stat {
            text-align: center;
        }
        
        .stat-value {
            font-size: 20px;
            font-weight: bold;
            color: #667eea;
        }
        
        .stat-label {
            font-size: 12px;
            color: #666;
        }
        
        .event-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }
        
        .event-actions a {
            flex: 1;
            text-align: center;
            padding: 10px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            color: white;
        }
        
        .view-btn { background: #667eea; }
        .edit-btn { background: #28a745; }
        .delete-btn { background: #dc3545; }
        
        .event-actions a:hover { opacity: 0.8; }
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 15px;
            margin-top: 20px;
        }
        
        .btn-primary {
            display: inline-block;
            background: #667eea;
            color: white;
            text-decoration: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: bold;
        }
        
        @media (max-width: 768px) {
            .dashboard-header {
                flex-direction: column;
                gap: 10px;
                text-align: center;
            }
            .event-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="dashboard-header">
            <div>
                <span class="role-badge">🎪 ORGANIZER</span>
                <h1>My Events</h1>
            </div>
            <div>
                <a href="create-event.php" class="logout-link" style="margin-right: 10px;">+ Create New</a>
                <a href="organizer-dashboard.php" class="logout-link">← Back</a>
            </div>
        </div>
        
        <?php if(empty($events)): ?>
            <div class="empty-state">
                <p>You haven't created any events yet.</p>
                <a href="create-event.php" class="btn-primary">Create Your First Event</a>
            </div>
        <?php else: ?>
            <div class="event-grid">
                <?php foreach($events as $event): ?>
                <div class="event-card">
                    <div class="event-card-header">
                        <h3><?php echo htmlspecialchars($event['title']); ?></h3>
                        <small><?php echo date('M j, Y', strtotime($event['event_date'])); ?></small>
                    </div>
                    <div class="event-card-body">
                        <p><strong>📍 Venue:</strong> <?php echo htmlspecialchars($event['venue']); ?></p>
                        <p><strong>💰 Price:</strong> RWF <?php echo number_format($event['price']); ?></p>
                        
                        <div class="event-stats">
                            <div class="stat">
                                <div class="stat-value"><?php echo $event['tickets_sold'] ?: 0; ?></div>
                                <div class="stat-label">Sold</div>
                            </div>
                            <div class="stat">
                                <div class="stat-value">RWF <?php echo number_format($event['revenue'] ?: 0); ?></div>
                                <div class="stat-label">Revenue</div>
                            </div>
                        </div>
                        
                        <div class="event-actions">
                            <a href="event.php?id=<?php echo $event['id']; ?>" class="view-btn" target="_blank">👁️ View</a>
                            <a href="edit-event.php?id=<?php echo $event['id']; ?>" class="edit-btn">✏️ Edit</a>
                            <a href="manage-events.php?delete=<?php echo $event['id']; ?>" class="delete-btn" onclick="return confirm('Delete this event?')">🗑️ Delete</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>