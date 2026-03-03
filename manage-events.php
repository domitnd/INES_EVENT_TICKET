<?php 
require_once 'config/database.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: admin-login.php');
    exit;
}

$user_type = $_SESSION['admin_type'];
$error = '';
$success = '';

// Handle delete event
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    
    // First delete related tickets
    $pdo->prepare("DELETE FROM tickets WHERE event_id = ?")->execute([$id]);
    // Then delete event
    $stmt = $pdo->prepare("DELETE FROM events WHERE id = ?");
    
    if ($stmt->execute([$id])) {
        $success = 'Event deleted successfully';
    } else {
        $error = 'Failed to delete event';
    }
}

// Get events
$stmt = $pdo->query("
    SELECT e.*, 
           (SELECT COUNT(*) FROM tickets WHERE event_id = e.id) as tickets_sold,
           COALESCE((SELECT SUM(total_amount) FROM tickets WHERE event_id = e.id), 0) as revenue
    FROM events e
    ORDER BY e.event_date DESC
");
$events = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Events</title>
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
            background: linear-gradient(135deg, #5ebd6e, #89c09e);
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
        }
        
        .error-message {
            background: #fee;
            color: #c00;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .dashboard-card {
            background: white;
            padding: 20px;
            border-radius: 15px;
        }
        
        .table-responsive {
            overflow-x: auto;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th {
            background: #f8f9fa;
            padding: 12px;
            text-align: left;
        }
        
        td {
            padding: 12px;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .event-status {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 12px;
        }
        
        .status-upcoming { background: #d4edda; color: #155724; }
        .status-ongoing { background: #fff3cd; color: #856404; }
        .status-past { background: #f8d7da; color: #721c24; }
        
        .action-buttons {
            display: flex;
            gap: 5px;
        }
        
        .view-btn, .edit-btn, .delete-btn {
            padding: 5px 10px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 13px;
            color: white;
        }
        
        .view-btn { background: #667eea; }
        .edit-btn { background: #28a745; }
        .delete-btn { background: #dc3545; }
        
        @media (max-width: 768px) {
            .dashboard-header {
                flex-direction: column;
                text-align: center;
            }
            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="dashboard-header">
            <div>
                <span class="role-badge"><?php echo $user_type == 'admin' ? '👑 ADMIN' : '🎪 ORGANIZER'; ?></span>
                <h1>Manage Events</h1>
            </div>
            <div>
                <a href="create-event.php" class="logout-link" style="margin-right: 10px;">+ New Event</a>
                <a href="<?php echo $user_type == 'admin' ? 'admin-dashboard.php' : 'organizer-dashboard.php'; ?>" class="logout-link">← Back</a>
            </div>
        </div>
        
        <?php if($error): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if($success): ?>
            <div class="success-message">✅ <?php echo $success; ?></div>
        <?php endif; ?>
        
        <div class="dashboard-card">
            <h3>All Events</h3>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Date</th>
                            <th>Venue</th>
                            <th>Price</th>
                            <th>Tickets</th>
                            <th>Revenue</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($events as $event): 
                            $today = date('Y-m-d');
                            if ($event['event_date'] > $today) {
                                $status = 'upcoming';
                                $status_text = 'Upcoming';
                            } elseif ($event['event_date'] == $today) {
                                $status = 'ongoing';
                                $status_text = 'Today';
                            } else {
                                $status = 'past';
                                $status_text = 'Past';
                            }
                        ?>
                        <tr>
                            <td>#<?php echo $event['id']; ?></td>
                            <td><?php echo htmlspecialchars(substr($event['title'], 0, 30)); ?>..</td>
                            <td><?php echo date('M j, Y', strtotime($event['event_date'])); ?></td>
                            <td><?php echo htmlspecialchars(substr($event['venue'], 0, 20)); ?></td>
                            <td>RWF <?php echo number_format($event['price']); ?></td>
                            <td><?php echo $event['tickets_sold']; ?></td>
                            <td>RWF <?php echo number_format($event['revenue'] ?: 0); ?></td>
                            <td><span class="event-status status-<?php echo $status; ?>"><?php echo $status_text; ?></span></td>
                            <td>
                                <div class="action-buttons">
                                    <a href="event.php?id=<?php echo $event['id']; ?>" class="view-btn" target="_blank">👁️ View</a>
                                    <a href="edit-event.php?id=<?php echo $event['id']; ?>" class="edit-btn">✏️ Edit</a>
                                    <a href="?delete=<?php echo $event['id']; ?>" class="delete-btn" onclick="return confirm('Delete this event?')">🗑️ Delete</a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
