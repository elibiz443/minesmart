document.addEventListener("DOMContentLoaded", function () {
  const scrollMap = {
    philosophyButton: "philosophy",
    philosophyButton2: "philosophy",
    architectureButton: "architecture",
    architectureButton2: "architecture",
    architectureButton3: "architecture",
    edgeButton: "edge",
    edgeButton2: "edge",
  };

  Object.entries(scrollMap).forEach(([btnId, targetId]) => {
    const btn = document.getElementById(btnId);
    if (btn) {
      btn.addEventListener("click", function (e) {
        e.preventDefault();
        const section = document.getElementById(targetId);
        section?.scrollIntoView({ behavior: "smooth" });
        history.pushState(null, null, " ");
      });
    }
  });
});