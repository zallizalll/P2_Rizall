document.addEventListener("DOMContentLoaded", () => {
    /* ======================
       STEP CONTROL (dari script lama)
    ====================== */
    const steps = ["a", "b", "c", "d"];

    const showStep = (active) => {
        steps.forEach((s) => {
            const stepEl = document.getElementById(`step-${s}`);
            if (!stepEl) return;

            const isActive = s === active;
            stepEl.style.display = isActive ? "block" : "none";
            toggleStepInputs(s, isActive);
        });
    };

    const toggleStepInputs = (step, enable) => {
        const el = document.getElementById(`step-${step}`);
        if (!el) return;

        el.querySelectorAll("input, select, textarea").forEach((i) => {
            i.disabled = !enable;
        });
    };

    /* ======================
        LIVE PREVIEW: Tanggal
    ====================== */
    document.addEventListener("input", function () {
        const tgl = document.getElementById("tanggal").value;
        document.getElementById("p-tanggal").textContent = tgl;
        document.getElementById("p-sincerely").textContent = tgl;
    });

    /* ======================
       LIVE PREVIEW TEXT (umum)
    ====================== */
    const bindText = (inputId, previewId) => {
        const i = document.getElementById(inputId);
        const p = document.getElementById(previewId);
        if (!i || !p) return;

        i.addEventListener("input", () => {
            if (i.tagName === "TEXTAREA") {
                p.innerHTML = (i.value || "-").replace(/\n/g, "<br>");
            } else {
                p.textContent = i.value || "-";
            }
        });
    };

    [
        ["tanggal", "p-tanggal"],
        ["subject", "p-subject"],
        ["penerima", "p-penerima"],
        ["p1", "p-p1"],
        ["p2", "p-p2"],
        ["p3", "p-p3"],
        ["nama_penyusun", "p-nama_penyusun"],
    ].forEach(([i, p]) => bindText(i, p));

    /* ======================
       LOGO PREVIEW
    ====================== */
    const logo = document.getElementById("logo");
    const logoPrev = document.getElementById("p-logo");

    if (logo) {
        logo.addEventListener("change", () => {
            const file = logo.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = (e) => {
                logoPrev.src = e.target.result;
                logoPrev.style.display = "block";
            };
            reader.readAsDataURL(file);
        });
    }

    /* ======================
       INIT
    ====================== */
    showStep("a");

    /* ======================
       PREVIEW LAMPIRAN (dipanggil)
    ====================== */
    if (typeof previewLampiran === "function") {
        previewLampiran("lkpd", "p-lkpd", "p-lkpd-img");
        previewLampiran("materi", "p-materi", "p-materi-img");
        previewLampiran("asesmen", "p-asesmen", "p-asesmen-img");
    }

    /* ======================
       PRINT BUTTON
    ====================== */
    document.getElementById("btnPrint").addEventListener("click", () => {
        window.print();
    });

    /* ======================
       CLEAR BUTTON (perbaikan)
    ====================== */
    document.getElementById("btnClear").addEventListener("click", () => {
        // Hapus semua input
        document
            .querySelectorAll("input, textarea")
            .forEach((i) => (i.value = ""));

        // Reset preview text
        const resets = [
            "p-tanggal",
            "p-subject",
            "p-penerima",
            "p-p1",
            "p-p2",
            "p-p3",
            "p-nama_penyusun",
        ];

        resets.forEach((id) => {
            const el = document.getElementById(id);
            if (el) el.textContent = "-";
        });

        // Reset logo
        const logoImg = document.getElementById("p-logo");
        if (logoImg) logoImg.style.display = "none";

        alert("Formulir berhasil di-reset!");
    });
});
