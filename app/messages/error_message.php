<script src="config/js/alerts/error.js"></script>
<?php if (isset($_SESSION['error_message'])): ?>
    <script>
        showErrorAlert('<?php echo $_SESSION['error_message']; ?>');
    </script>
    <?php unset($_SESSION['error_message']); ?>
<?php endif; ?>