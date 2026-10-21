/* OTP feedback without duplicate session alerts or accidental auto-submission. */
(() => {
    const countdown = document.getElementById("otp-countdown");
    if (countdown) {
        const update = () => {
            const remaining = Math.max(
                0,
                Number(countdown.dataset.expires) -
                    Math.floor(Date.now() / 1000),
            );
            countdown.textContent = remaining
                ? `পুনরায় কোড পাঠানোর সময়: ${Math.floor(remaining / 60)}:${String(remaining % 60).padStart(2, "0")}`
                : "কোডের মেয়াদ শেষ হয়েছে।";
            document.getElementById("otp-resend").hidden = remaining > 0;
            return remaining;
        };
        if (update()) {
            const timer = setInterval(() => {
                if (!update()) clearInterval(timer);
            }, 1000);
        }
    }
    document.getElementById("login-otp")?.addEventListener("input", (event) => {
        event.target.value = event.target.value.replace(/\D/g, "").slice(0, 4);
    });
    document.querySelectorAll("[data-login-form]").forEach((form) =>
        form.addEventListener("submit", (event) => {
            if (form.dataset.busy) {
                event.preventDefault();
                return;
            }
            form.dataset.busy = "true";
            const button = form.querySelector("button[type=submit]");
            button.disabled = true;
            button.textContent = "Please wait…";
        }),
    );
    const profile = document.querySelector("[data-account-profile]");
    if (profile) {
        const division = document.getElementById("division");
        const district = document.getElementById("district");
        const upazila = document.getElementById("upazila");
        const reset = (select, label) =>
            select.replaceChildren(new Option(label, ""));
        const pending = new Map();
        const populate = async (select, url, key, value, selected = "") => {
            pending.get(select)?.abort();
            const controller = new AbortController();
            pending.set(select, controller);
            select.disabled = true;
            try {
                const requestUrl = new URL(url, location.origin);
                requestUrl.searchParams.set(key, value);
                const response = await fetch(requestUrl, {
                    signal: controller.signal,
                    headers: { Accept: "application/json" },
                });
                if (!response.ok)
                    throw new Error(
                        "Could not load locations. Please try again.",
                    );
                for (const item of await response.json())
                    select.add(
                        new Option(
                            item.name,
                            item.id,
                            false,
                            String(item.id) === String(selected),
                        ),
                    );
            } catch (error) {
                if (error.name !== "AbortError")
                    window.Unibox.notify(error.message, true);
            } finally {
                if (pending.get(select) === controller) select.disabled = false;
            }
        };
        division.addEventListener("change", async () => {
            pending.get(district)?.abort();
            pending.get(upazila)?.abort();
            reset(district, "Select District");
            reset(upazila, "Select Upazila");
            if (division.value)
                await populate(
                    district,
                    profile.dataset.districtUrl,
                    "division_id",
                    division.value,
                );
        });
        district.addEventListener("change", async () => {
            pending.get(upazila)?.abort();
            reset(upazila, "Select Upazila");
            if (district.value)
                await populate(
                    upazila,
                    profile.dataset.upazilaUrl,
                    "district_id",
                    district.value,
                );
        });
        if (division.value) {
            const selectedDistrict =
                document.getElementById("selected_district").value;
            populate(
                district,
                profile.dataset.districtUrl,
                "division_id",
                division.value,
                selectedDistrict,
            ).then(() => {
                if (district.value)
                    populate(
                        upazila,
                        profile.dataset.upazilaUrl,
                        "district_id",
                        district.value,
                        document.getElementById("selected_upazila").value,
                    );
            });
        }
    }
})();
