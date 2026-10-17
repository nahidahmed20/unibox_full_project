/* Homepage carousel: no third-party dependency; first slide works without JS. */
(() => {
    const rail = document.querySelector(".ub-collection-rail");
    const collectionControls = document.querySelector(
        "[data-collection-controls]",
    );
    if (rail && collectionControls) {
        collectionControls.hidden = false;
        const previous = collectionControls.querySelector(
            "[data-collection-prev]",
        );
        const next = collectionControls.querySelector("[data-collection-next]");
        const update = () => {
            previous.disabled = rail.scrollLeft < 2;
            next.disabled =
                rail.scrollLeft + rail.clientWidth >= rail.scrollWidth - 2;
        };
        for (const [button, direction] of [
            [previous, -1],
            [next, 1],
        ]) {
            button.addEventListener("click", () =>
                rail.scrollBy({
                    left: direction * rail.clientWidth * 0.8,
                    behavior: matchMedia("(prefers-reduced-motion: reduce)")
                        .matches
                        ? "auto"
                        : "smooth",
                }),
            );
        }
        rail.addEventListener("scroll", update, { passive: true });
        window.addEventListener("resize", update);
        update();
    }
    const root = document.querySelector("[data-hero-slider]");
    if (!root) return;
    const slides = [...root.querySelectorAll("[data-slide]")];
    if (slides.length < 2) return;
    const controls = root.querySelector("[data-slide-controls]");
    const dots = [...root.querySelectorAll("[data-slide-to]")];
    const pause = root.querySelector("[data-slide-pause]");
    const reduced = matchMedia("(prefers-reduced-motion: reduce)");
    let current = 0,
        paused = reduced.matches,
        visible = true,
        keyboardFocus = false,
        timer;
    controls.hidden = false;
    const schedule = () => {
        clearTimeout(timer);
        if (!paused && visible && !document.hidden && !keyboardFocus) {
            timer = setTimeout(() => show(current + 1), 5000);
        }
    };
    const updatePause = () => {
        pause.setAttribute(
            "aria-label",
            paused ? "Play slideshow" : "Pause slideshow",
        );
        pause.innerHTML = `<i class="fa-solid fa-${paused ? "play" : "pause"}" aria-hidden="true"></i>`;
    };
    const show = (index, manual = false) => {
        current = (index + slides.length) % slides.length;
        slides.forEach((slide, i) => {
            slide.hidden = i !== current;
            slide.classList.toggle("is-current", i === current);
        });
        dots.forEach((dot, i) =>
            dot.setAttribute("aria-pressed", String(i === current)),
        );
        root.querySelector("[data-slide-counter]").textContent =
            `${current + 1} / ${slides.length}`;
        if (manual) {
            root.querySelector("[data-slide-status]").textContent =
                `Slide ${current + 1} of ${slides.length}`;
        }
        schedule();
    };
    root.querySelector("[data-slide-prev]").addEventListener("click", () =>
        show(current - 1, true),
    );
    root.querySelector("[data-slide-next]").addEventListener("click", () =>
        show(current + 1, true),
    );
    dots.forEach((dot) =>
        dot.addEventListener("click", () =>
            show(Number(dot.dataset.slideTo), true),
        ),
    );
    pause.addEventListener("click", () => {
        paused = !paused;
        keyboardFocus = false;
        updatePause();
        schedule();
    });
    root.addEventListener("focusin", (event) => {
        keyboardFocus = event.target.matches(":focus-visible");
        schedule();
    });
    root.addEventListener("focusout", () =>
        setTimeout(() => {
            keyboardFocus =
                root.contains(document.activeElement) &&
                document.activeElement.matches(":focus-visible");
            schedule();
        }, 0),
    );
    root.addEventListener("keydown", (event) => {
        if (!["ArrowLeft", "ArrowRight"].includes(event.key)) return;
        event.preventDefault();
        show(current + (event.key === "ArrowRight" ? 1 : -1), true);
    });
    let touch;
    root.addEventListener(
        "touchstart",
        (event) => {
            touch =
                event.touches.length === 1
                    ? {
                          x: event.touches[0].clientX,
                          y: event.touches[0].clientY,
                      }
                    : null;
        },
        { passive: true },
    );
    root.addEventListener(
        "touchend",
        (event) => {
            if (!touch) return;
            const dx = event.changedTouches[0].clientX - touch.x;
            const dy = event.changedTouches[0].clientY - touch.y;
            if (Math.abs(dx) > 60 && Math.abs(dx) > Math.abs(dy) * 1.5)
                show(current + (dx < 0 ? 1 : -1), true);
            touch = null;
        },
        { passive: true },
    );
    document.addEventListener("visibilitychange", schedule);
    reduced.addEventListener("change", () => {
        paused = reduced.matches;
        updatePause();
        schedule();
    });
    if ("IntersectionObserver" in window) {
        new IntersectionObserver(
            (entries) => {
                visible = entries[0].isIntersecting;
                schedule();
            },
            { threshold: 0.2 },
        ).observe(root);
    }
    updatePause();
    schedule();
})();
