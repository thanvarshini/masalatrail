<script>
  function toggleDropdown() {
    const dropdown = document.getElementById("dropdown");
    dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
  }

  // Fix: Close dropdown only if clicking outside the entire custom-select
  document.addEventListener("click", function (e) {
    const customSelect = document.querySelector(".custom-select");
    if (!customSelect.contains(e.target)) {
      document.getElementById("dropdown").style.display = "none";
    }
  });
</script>
