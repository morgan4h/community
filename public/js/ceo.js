document.addEventListener("DOMContentLoaded", () => {
    const navItems = document.querySelectorAll("nav li");
    const sections = document.querySelectorAll(".panel-section");

    // 1. TAB SWITCHING WITH PERSISTENCE
    const activateTab = (index) => {
        navItems.forEach(nav => nav.classList.remove("active"));
        sections.forEach(sec => sec.classList.remove("active"));

        if (navItems[index] && sections[index]) {
            navItems[index].classList.add("active");
            sections[index].classList.add("active");
            localStorage.setItem("activeCeoTab", index);
        }
    };

    const savedTabIndex = localStorage.getItem("activeCeoTab");
    if (savedTabIndex !== null && !isNaN(savedTabIndex) && savedTabIndex < navItems.length) {
        activateTab(parseInt(savedTabIndex, 10));
    } else {
        activateTab(0);
    }

    navItems.forEach((item, index) => {
        item.addEventListener("click", () => activateTab(index));
    });

    // 2. MODAL CONTROLS
    const userModal = document.getElementById("userModal");
    const apiModal = document.getElementById("apiModal");

    // Close Modals handler
    document.querySelectorAll(".btn-close-modal").forEach(btn => {
        btn.addEventListener("click", () => {
            userModal.classList.remove("active");
            apiModal.classList.remove("active");
        });
    });

    // Open User Update Modal with filled data
    document.querySelectorAll(".btn-open-user-modal").forEach(btn => {
        btn.addEventListener("click", () => {
            const id = btn.getAttribute("data-id");
            const name = btn.getAttribute("data-name");
            const isAdmin = btn.getAttribute("data-admin");

            document.getElementById("userUpdateForm").action = `/users/${id}`;
            document.getElementById("modalUserName").value = name;
            document.getElementById("modalUserAdmin").value = isAdmin;

            userModal.classList.add("active");
        });
    });

    // Open API Update Modal with filled data
    document.querySelectorAll(".btn-open-api-modal").forEach(btn => {
        btn.addEventListener("click", () => {
            const id = btn.getAttribute("data-id");
            const name = btn.getAttribute("data-name");
            const api = btn.getAttribute("data-api");
            const category = btn.getAttribute("data-category");

            document.getElementById("apiUpdateForm").action = `/apis/${id}`;
            document.getElementById("modalApiName").value = name;
            document.getElementById("modalApiUrl").value = api;
            document.getElementById("modalApiCategory").value = category;

            apiModal.classList.add("active");
        });
    });
});