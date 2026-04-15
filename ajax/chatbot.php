<?php
header('Content-Type: application/json');
session_start();
require_once '../config/database.php';

$response = [
    'success' => false,
    'message' => '',
    'session_id' => session_id()
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_message = isset($_POST['message']) ? trim($_POST['message']) : '';
    
    if (empty($user_message)) {
        $response['message'] = 'Please enter a message.';
        echo json_encode($response);
        exit;
    }
    
    // Get or create visitor ID
    if (!isset($_SESSION['visitor_id'])) {
        $_SESSION['visitor_id'] = bin2hex(random_bytes(16));
    }
    $visitor_id = $_SESSION['visitor_id'];
    
    // Get chatbot response
    $bot_response = getChatbotResponse($user_message, $pdo);
    
    // Log conversation
    try {
        $stmt = $pdo->prepare("INSERT INTO chatbot_conversations (visitor_id, message, response, category) VALUES (?, ?, ?, ?)");
        $stmt->execute([$visitor_id, $user_message, $bot_response['text'], $bot_response['category']]);
    } catch (Exception $e) {
        // Log error but don't break response
    }
    
    $response['success'] = true;
    $response['message'] = $bot_response['text'];
    $response['category'] = $bot_response['category'];
}

echo json_encode($response);

/**
 * Get chatbot response based on user message
 */
function getChatbotResponse($user_input, $pdo) {
    $user_input = strtolower(trim($user_input));
    $best_match = null;
    $best_priority = -1;
    $best_keyword_length = 0;
    
    try {
        // Get all KB entries
        $stmt = $pdo->query("SELECT * FROM chatbot_kb WHERE active = 1 ORDER BY priority DESC");
        $kb_entries = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Find best matching response
        foreach ($kb_entries as $entry) {
            $keyword = strtolower($entry['keyword']);
            $keyword_length = strlen($keyword);
            
            // Check if keyword is in user input
            if (strpos($user_input, $keyword) !== false) {
                // Prioritize longer keywords (more specific)
                if ($entry['priority'] > $best_priority || 
                    ($entry['priority'] == $best_priority && $keyword_length > $best_keyword_length)) {
                    $best_match = $entry;
                    $best_priority = $entry['priority'];
                    $best_keyword_length = $keyword_length;
                }
            }
        }
    } catch (Exception $e) {
        // Database error, use default response
    }
    
    // Return best match or default response
    if ($best_match) {
        return [
            'text' => $best_match['response'],
            'category' => $best_match['category']
        ];
    }
    
    // Default response for unmatched queries
    return [
        'text' => "I'm not sure about that. Could you provide more details? You can also:\n• Browse our products on the Products page\n• Contact us for specific queries\n• Check FAQ section for common questions",
        'category' => 'general'
    ];
}
?>
