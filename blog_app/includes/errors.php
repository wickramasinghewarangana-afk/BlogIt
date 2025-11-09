<?php
// Tailwind styled alert boxes for BlogIt

// ✅ Error messages (local $errors array)
if (isset($errors) && count($errors) > 0): ?>
    <div id="errorBox" class="mb-6 bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded-lg shadow-sm transition-opacity duration-1000">
        <div class="flex items-center justify-between">
            <div>
                <strong class="font-semibold">⚠️ Oops!</strong>
                <?php foreach ($errors as $error): ?>
                    <p class="mt-1 text-sm"><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
            <button onclick="this.parentElement.parentElement.style.display='none'" class="text-red-600 hover:text-red-800 text-lg leading-none font-bold">&times;</button>
        </div>
    </div>
<?php endif; ?>

<?php
// ✅ Success messages (session message)
if (isset($_SESSION['message'])): ?>
    <div id="successBox" class="mb-6 bg-emerald-50 border border-emerald-300 text-emerald-700 px-4 py-3 rounded-lg shadow-sm transition-opacity duration-1000">
        <div class="flex items-center justify-between">
            <div>
                <strong class="font-semibold">✅ Success!</strong>
                <p class="mt-1 text-sm"><?php echo htmlspecialchars($_SESSION['message']); ?></p>
            </div>
            <button onclick="this.parentElement.parentElement.style.display='none'" class="text-emerald-600 hover:text-emerald-800 text-lg leading-none font-bold">&times;</button>
        </div>
    </div>
    <?php unset($_SESSION['message']); ?>
<?php endif; ?>

<!-- Fade out effect -->
<script>
document.addEventListener("DOMContentLoaded", () => {
    const successBox = document.getElementById("successBox");
    const errorBox = document.getElementById("errorBox");
    [successBox, errorBox].forEach(box => {
        if (box) {
            setTimeout(() => {
                box.style.opacity = "0";
                setTimeout(() => box.style.display = "none", 1000);
            }, 4000); // fade after 4 seconds
        }
    });
});
</script>


