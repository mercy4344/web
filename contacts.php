<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $message = htmlspecialchars($_POST["message"]);
    $message = htmlspecialchars($_POST["phone"]);

    if (empty($name) || empty($email) || empty($message)) {
        echo json_encode(["error" => "All fields are required!"]);
        exit;
    }

    try {
        $pdo = new PDO("mysql:host=localhost;dbname=chain_education", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("INSERT INTO contacts (name, email, message) VALUES (:name, :email, :message)");
        $stmt->execute([
            ":name" => $name,
            ":email" => $email,
            ":message" => $message
        ]);

        echo json_encode(["success" => "Message sent successfully!"]);
    } catch (PDOException $e) {
        echo json_encode(["error" => "Database error: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["error" => "Invalid request method!"]);
}
?>
