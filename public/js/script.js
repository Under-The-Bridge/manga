document.querySelectorAll(".manga-group").forEach(group => {
    const overflow = group.querySelector(".overflow");
    const leftBtn = group.querySelector(".arrow-left");
    const rightBtn = group.querySelector(".arrow-right");

    if (!overflow || !leftBtn || !rightBtn) return;

    const step = 175;
    let position = 0;

    const maxScroll = () => {
        const totalWidth = overflow.scrollWidth;
        const visibleWidth = overflow.parentElement.clientWidth;
        return Math.min(0, visibleWidth - totalWidth);
    };

    function update() {
        if (position > 0) position = 0;
        if (position < maxScroll()) position = maxScroll();
        overflow.style.transform = `translateX(${position}px)`;
    }

    leftBtn.addEventListener("click", () => {
        position += step;
        update();
    });

    rightBtn.addEventListener("click", () => {
        position -= step;
        update();
    });
    update();
});
