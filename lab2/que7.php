<?php
// Get submitted values (if any) to preserve user input
$wins = isset($_POST['wins']) ? $_POST['wins'] : '';
$draws = isset($_POST['draws']) ? $_POST['draws'] : '';
$losses = isset($_POST['losses']) ? $_POST['losses'] : '';
?>

<!-- HTML form to accept wins, draws, and losses -->
<form method="post">
    Wins: <input type="number" name="wins" value="<?php echo htmlspecialchars($wins); ?>" required><br>
    Draws: <input type="number" name="draws" value="<?php echo htmlspecialchars($draws); ?>" required><br>
    Losses: <input type="number" name="losses" value="<?php echo htmlspecialchars($losses); ?>" required><br>
    <input type="submit" name="submit" value="Calculate">
</form>

<?php
// Function to calculate total points (Win=3, Draw=1, Loss=0)
function calculatePoints($wins, $draws, $losses) {
    return ($wins * 3) + ($draws * 1) + ($losses * 0);
}

// Check if form is submitted
if (isset($_POST['submit'])) {
    
    // Validate that inputs are not negative
    if ($wins < 0 || $draws < 0 || $losses < 0) {
        echo "Error: Values cannot be negative.";
    } else {
        // Calculate total games played and total points
        $totalGames = $wins + $draws + $losses;
        $totalPoints = calculatePoints($wins, $draws, $losses);
        
        // Display the final results
        echo "<br><strong>Total Games Played:</strong> $totalGames <br>";
        echo "<strong>Total Points Obtained:</strong> $totalPoints";
    }
}
?>