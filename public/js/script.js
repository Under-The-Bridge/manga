// Each rail has its own scroll state; native scrolling also supports keyboards.
document.querySelectorAll(".manga-group").forEach((group) => {
    const rail = group.querySelector(".manga-rail");
    const buttons = group.querySelectorAll("[data-scroll]");
    if (!rail) return;
    const update = () =>
        buttons.forEach((button) => {
            button.disabled =
                Number(button.dataset.scroll) < 0
                    ? rail.scrollLeft <= 1
                    : rail.scrollLeft + rail.clientWidth >=
                      rail.scrollWidth - 1;
        });
    buttons.forEach((button) =>
        button.addEventListener("click", () => {
            rail.scrollBy({
                left: Number(button.dataset.scroll) * 350,
                behavior: "smooth",
            });
        }),
    );
    rail.addEventListener("scroll", update, { passive: true });
    new ResizeObserver(update).observe(rail);
    update();
});

const tabs = [...document.querySelectorAll('[role="tab"]')];
function selectTab(tab, focus = false) {
    tabs.forEach((item) => {
        const selected = item === tab;
        item.setAttribute("aria-selected", String(selected));
        item.tabIndex = selected ? 0 : -1;
        document.getElementById(item.getAttribute("aria-controls")).hidden =
            !selected;
    });
    if (focus) tab.focus();
}
tabs.forEach((tab, index) => {
    tab.addEventListener("click", () => selectTab(tab));
    tab.addEventListener("keydown", (event) => {
        let next;
        if (event.key === "ArrowRight") next = (index + 1) % tabs.length;
        if (event.key === "ArrowLeft")
            next = (index - 1 + tabs.length) % tabs.length;
        if (event.key === "Home") next = 0;
        if (event.key === "End") next = tabs.length - 1;
        if (next !== undefined) {
            event.preventDefault();
            selectTab(tabs[next], true);
        }
    });
});
document.querySelectorAll("[data-select-tab]").forEach((button) =>
    button.addEventListener("click", () => {
        const tab = tabs.find(
            (tab) =>
                tab.getAttribute("aria-controls") === button.dataset.selectTab,
        );
        if (tab) {
            selectTab(tab, true);
            tab.scrollIntoView({ block: "center", behavior: "smooth" });
        }
    }),
);

// Plans are saved on this device until reader libraries are connected to accounts.
document.querySelectorAll("[data-plan]").forEach((button) => {
    const key = `webmanga:plan:${button.dataset.plan}`;
    let planned = false;
    try {
        planned = localStorage.getItem(key) === "true";
    } catch {
        /* Storage may be disabled. */
    }
    const update = () => {
        button.setAttribute("aria-pressed", String(planned));
        button.textContent = planned ? "✓ В планах" : "+ Добавить в планы ⌄";
    };
    update();
    button.addEventListener("click", () => {
        planned = !planned;
        try {
            localStorage.setItem(key, String(planned));
        } catch {
            /* Keep the control usable for this visit. */
        }
        update();
    });
});

const dialog = document.getElementById("site-dialog");
let dialogTrigger;
document.querySelectorAll("[data-dialog-title]").forEach((button) =>
    button.addEventListener("click", () => {
        dialogTrigger = button;
        document.getElementById("dialog-title").textContent =
            button.dataset.dialogTitle;
        document.getElementById("dialog-copy").textContent =
            button.dataset.dialogCopy;
        dialog.showModal();
    }),
);
document
    .querySelector("[data-close-dialog]")
    ?.addEventListener("click", () => dialog.close());
dialog?.addEventListener("click", (event) => {
    if (event.target === dialog) dialog.close();
});
dialog?.addEventListener("close", () => dialogTrigger?.focus());
