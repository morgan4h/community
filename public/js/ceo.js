document.addEventListener("DOMContentLoaded", () => {
    const navItems = document.querySelectorAll("nav li");
    const sections = document.querySelectorAll(".panel-section");

    // Format items into clean layout containers dynamically
    sections.forEach(sec => {
        if (sec.classList.contains("users") || sec.classList.contains("content")) {
            const wrapper = document.createElement("div");
            wrapper.className = "scroll-container";
            const targetClass = sec.classList.contains("users") ? ".user" : ".link";
            const items = sec.querySelectorAll(targetClass);
            
            items.forEach(item => {
                if (!item.querySelector(".item-info")) {
                    const h1 = item.querySelector("h1");
                    const p = item.querySelector("p");
                    const buttons = item.querySelectorAll("button");

                    const infoDiv = document.createElement("div");
                    infoDiv.className = "item-info";
                    if (h1) infoDiv.appendChild(h1);
                    if (p) infoDiv.appendChild(p);

                    const btnDiv = document.createElement("div");
                    btnDiv.className = "item-actions";
                    buttons.forEach(btn => btnDiv.appendChild(btn));

                    item.innerHTML = "";
                    item.appendChild(infoDiv);
                    item.appendChild(btnDiv);
                }
                wrapper.appendChild(item);
            });
            sec.appendChild(wrapper);
        }
    });

    // Set default initial view
    document.querySelector(".users").classList.add("active");
    navItems[0].classList.add("active");

    // Tab switching logic
    navItems.forEach((item, index) => {
        item.addEventListener("click", () => {
            navItems.forEach(nav => nav.classList.remove("active"));
            sections.forEach(sec => sec.classList.remove("active"));

            item.classList.add("active");
            sections[index].classList.add("active");
        });
    });

    // Action handling: Console log delete, update, and add submit actions instead of modifying DOM
    document.addEventListener("click", (e) => {
        if (e.target.tagName === "BUTTON") {
            const actionText = e.target.textContent.toLowerCase();
            const targetItem = e.target.closest(".user, .link");

            if (actionText === "delete") {
                const itemName = targetItem ? targetItem.querySelector("h1").textContent : "Unknown";
                console.log(`Action: Delete clicked for item -> ${itemName}`);
            } else if (actionText === "update") {
                const itemName = targetItem ? targetItem.querySelector("h1").textContent : "Unknown";
                console.log(`Action: Update clicked for item -> ${itemName}`);
            }
        }
    });

    // Add new link handler: Console log submission instead of appending to DOM
    const addLinkBtn = document.querySelector(".add-link button");
    if (addLinkBtn) {
        addLinkBtn.addEventListener("click", () => {
            const inputs = document.querySelectorAll(".add-link input");
            const name = inputs[0].value.trim();
            const url = inputs[1].value.trim();

            if (!name || !url) {
                alert("Please fill in both fields.");
                return;
            }

            console.log(`Action: Submit new link -> Name: ${name}, URL: ${url}`);

            inputs[0].value = "";
            inputs[1].value = "";
            navItems[1].click();
        });
    }
});