<script src="config/js/alerts/success.js"></script>
<?php if (isset($_SESSION['success_message'])): ?>
    <script>
        showSucessoAlert('<?php echo $_SESSION['success_message']; ?>');
    </script>
    <?php unset($_SESSION['success_message']); ?>
<?php endif; ?>
