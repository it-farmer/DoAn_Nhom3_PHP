

<?php
$title = "Liên hệ";
include 'header.php';
?>
<br>
<br>
<br>
<style>
    .content-container {
        margin-top: 200px;
        width: 80%;
        margin: 0 auto;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .contact-title {
        text-align: center;
        font-size: 24px;
        margin-bottom: 20px;
    }

    .contact-form {
        display: flex;
        flex-direction: column;
    }

    .contact-form label {
        margin-bottom: 5px;
        font-weight: bold;
    }

    .contact-form input,
    .contact-form textarea {
        padding: 10px;
        margin-bottom: 15px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    .contact-form button {
        padding: 10px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .contact-form button:hover {
        background-color: #0056b3;
    }

    .success-message {
        text-align: center;
        color: green;
        margin-top: 20px;
    }
</style>
<div class="content-container">
    <h1 class="contact-title">Liên Hệ Với Chúng Tôi</h1>
    <form method="post" class="contact-form">
        <label>Họ và tên:</label>
        <input type="text" name="name" required>

        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Nội dung:</label>
        <textarea name="message" required rows="5"></textarea>

        <button type="submit" name="submit">Gửi</button>
    </form>

    <?php
    if (isset($_POST['submit'])) {
        echo "<p class='success-message'>Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi trong thời gian sớm nhất.</p>";
    }
    ?>
</div>

<?php
include 'footer.php';
?>
