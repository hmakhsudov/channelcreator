<?php
// Function to check if a channel is in a user's favorites
function checkIfChannelIsFavorite($conn, $userId, $channelId) {
    $sql = "SELECT * FROM favorite_channels WHERE user_id = ? AND channel_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $userId, $channelId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result->num_rows > 0;
}

// Function to add a channel to a user's favorites
function addToFavorites($conn, $userId, $channelId) {
    $sql = "INSERT INTO favorite_channels (user_id, channel_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $userId, $channelId);
    
    return $stmt->execute();
}

// Function to remove a channel from a user's favorites
function removeFromFavorites($conn, $userId, $channelId) {
    $sql = "DELETE FROM favorite_channels WHERE user_id = ? AND channel_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $userId, $channelId);
    
    return $stmt->execute();
}
?>
