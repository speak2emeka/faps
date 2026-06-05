const SchoolData = {
  news: [
    { id: 1, title: "Admissions open for the new academic session", category: "announcement", excerpt: "Families can now apply for FAPS early years, primary, JSS, and SSS classes.", content: "Admissions are open across the unified school system with placement support for every learner.", published_date: "2026-06-01" },
    { id: 2, title: "Robotics learners begin engineering challenge series", category: "robotics", excerpt: "Students are designing sensor-driven prototypes in the STEM and Robotics Lab.", content: "The challenge series develops coding, teamwork, design thinking, and presentation skills.", published_date: "2026-05-24" },
    { id: 3, title: "Digital literacy week celebrates student innovation", category: "stem", excerpt: "Learners showcased websites, data projects, and creative computing portfolios.", content: "Digital literacy remains central to the school's 21st-century learning commitment.", published_date: "2026-05-10" }
  ],
  events: [
    { id: 1, title: "STEM Fair and Robotics Showcase", category: "stem", event_date: "2026-07-18", location: "Multipurpose Hall", description: "A whole-school exhibition of science, coding, and robotics projects." },
    { id: 2, title: "Entrance Assessment Day", category: "academic", event_date: "2026-07-25", location: "Admissions Office", description: "Prospective pupils and students complete age-appropriate placement assessments." },
    { id: 3, title: "Leadership and Career Week", category: "leadership", event_date: "2026-08-08", location: "Royal Prestige Leadership Academy", description: "Senior students meet professionals and practise leadership presentations." }
  ],
  gallery: [
    { id: 1, title: "Collaborative classroom learning", category: "academics", media_type: "image", media_url: "../images/course-1.jpg" },
    { id: 2, title: "Young learners at play", category: "school-life", media_type: "image", media_url: "../images/image_2.jpg" },
    { id: 3, title: "Science practical session", category: "stem", media_type: "image", media_url: "../images/course-3.jpg" },
    { id: 4, title: "Sports and teamwork", category: "sports", media_type: "image", media_url: "../images/event-4.jpg" },
    { id: 5, title: "Library reading culture", category: "facilities", media_type: "image", media_url: "../images/course-5.jpg" },
    { id: 6, title: "School celebration", category: "events", media_type: "image", media_url: "../images/event-6.jpg" }
  ],
  stem: [
    { title: "Coding Classes", program_type: "coding", target_level: "primary", description: "Scratch, Python, web basics, algorithms, and creative computing projects." },
    { title: "Robotics Kits", program_type: "robotics", target_level: "jss", description: "Hands-on builds using programmable kits, sensors, motors, and controllers." },
    { title: "Engineering Challenges", program_type: "engineering", target_level: "all", description: "Design thinking projects that connect maths, science, teamwork, and problem solving." },
    { title: "Science Labs", program_type: "science-lab", target_level: "sss", description: "Structured practicals in physics, chemistry, biology, observation, and reporting." },
    { title: "Competitions", program_type: "competitions", target_level: "all", description: "Preparation for STEM fairs, coding showcases, debates, and innovation contests." }
  ],
  downloads: [
    { title: "Admission Application Form", category: "admission-forms", description: "Application form for new pupils and students.", file_path: "#" },
    { title: "Parent Handbook", category: "policies", description: "Key school policies, routines, and expectations.", file_path: "#" },
    { title: "Academic Calendar", category: "schedules", description: "Term dates, holidays, and major events.", file_path: "#" }
  ]
};

class SchoolWebsite {
  constructor() {
    this.apiBase = new URL("../api/", window.location.href);
    this.whatsappNumber = "2341234567890";
    this.whatsappMessage = "Hello FAPS and Royal Prestige Leadership Academy. I would like to make an enquiry.";
    this.init();
  }

  init() {
    this.setupNav();
    this.setupWhatsApp();
    this.setupAnimations();
    this.setupNewsletter();
    this.setupContactForm();
    this.setupLightbox();
  }

  setupNav() {
    const toggle = document.querySelector("[data-nav-toggle]");
    const nav = document.querySelector("[data-site-nav]");
    if (toggle && nav) toggle.addEventListener("click", () => nav.classList.toggle("open"));
    const page = document.body.dataset.page;
    document.querySelectorAll("[data-site-nav] a").forEach((link) => {
      if (link.dataset.page === page) link.classList.add("active");
    });
  }

  setupWhatsApp() {
    if (document.querySelector(".whatsapp-button")) return;
    const link = document.createElement("a");
    link.className = "whatsapp-button";
    link.href = `https://wa.me/${this.whatsappNumber}?text=${encodeURIComponent(this.whatsappMessage)}`;
    link.target = "_blank";
    link.rel = "noopener";
    link.setAttribute("aria-label", "Chat with the school on WhatsApp");
    link.innerHTML = '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20.52 3.48A11.78 11.78 0 0 0 12.02 0C5.49 0 .18 5.31.18 11.84c0 2.08.55 4.12 1.59 5.92L0 24l6.39-1.68a11.85 11.85 0 0 0 5.63 1.43h.01c6.53 0 11.84-5.31 11.84-11.84 0-3.16-1.23-6.13-3.35-8.43Zm-8.5 18.26h-.01a9.83 9.83 0 0 1-5.01-1.37l-.36-.22-3.79.99 1.01-3.69-.24-.38a9.82 9.82 0 1 1 8.4 4.67Zm5.39-7.36c-.3-.15-1.75-.86-2.02-.96-.27-.1-.47-.15-.67.15-.2.3-.77.96-.94 1.16-.17.2-.35.22-.64.07-.3-.15-1.25-.46-2.39-1.47-.88-.79-1.48-1.76-1.65-2.06-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.03-.52-.07-.15-.67-1.61-.91-2.21-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.79.37-.27.3-1.04 1.02-1.04 2.48s1.07 2.87 1.21 3.07c.15.2 2.1 3.2 5.08 4.49.71.31 1.26.49 1.69.63.71.23 1.36.2 1.87.12.57-.09 1.75-.72 2-1.41.25-.69.25-1.29.17-1.41-.07-.13-.27-.2-.57-.35Z"/></svg>';
    document.body.appendChild(link);
  }

  setupAnimations() {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => entry.isIntersecting && entry.target.classList.add("in-view"));
    }, { threshold: 0.12 });
    document.querySelectorAll(".fade-up").forEach((el) => observer.observe(el));
  }

  setupNewsletter() {
    const form = document.querySelector("[data-newsletter-form]");
    if (!form) return;
    form.addEventListener("submit", async (event) => {
      event.preventDefault();
      const ok = await this.postForm("newsletter.php", new FormData(form));
      this.toast(ok ? "Newsletter subscription received." : "Subscription saved locally for now. Please try again later.");
      if (ok) form.reset();
    });
  }

  setupContactForm() {
    const form = document.querySelector("[data-contact-form]");
    if (!form) return;
    form.addEventListener("submit", async (event) => {
      event.preventDefault();
      const ok = await this.postForm("contact.php", new FormData(form));
      this.toast(ok ? "Message sent. The school team will respond soon." : "Your message is ready, but the server is not available yet.");
      if (ok) form.reset();
    });
  }

  setupLightbox() {
    const box = document.querySelector("[data-lightbox]");
    if (!box) return;
    const media = box.querySelector("[data-lightbox-media]");
    const title = box.querySelector("[data-lightbox-title]");
    box.querySelector("[data-lightbox-close]").addEventListener("click", () => box.classList.remove("active"));
    box.addEventListener("click", (event) => { if (event.target === box) box.classList.remove("active"); });
    document.addEventListener("click", (event) => {
      const item = event.target.closest("[data-lightbox-item]");
      if (!item) return;
      media.innerHTML = item.dataset.type === "video"
        ? `<video src="${item.dataset.src}" controls autoplay></video>`
        : `<img src="${item.dataset.src}" alt="${item.dataset.title}">`;
      title.textContent = item.dataset.title;
      box.classList.add("active");
    });
  }

  async postForm(endpoint, formData) {
    try {
      const response = await fetch(new URL(endpoint, this.apiBase), { method: "POST", body: formData });
      const data = await response.json();
      return Boolean(data.success);
    } catch {
      return false;
    }
  }

  async fetchContent(endpoint, fallback, params = {}) {
    try {
      const url = new URL(endpoint, this.apiBase);
      Object.entries(params).forEach(([key, value]) => value && url.searchParams.set(key, value));
      const response = await fetch(url);
      const data = await response.json();
      if (data.success) return data.data.items || data.data;
    } catch {}
    return fallback;
  }

  toast(message) {
    const notice = document.createElement("div");
    notice.className = "message";
    notice.style.cssText = "position:fixed;left:20px;bottom:88px;z-index:80;max-width:360px;box-shadow:var(--shadow);";
    notice.textContent = message;
    document.body.appendChild(notice);
    setTimeout(() => notice.remove(), 4200);
  }
}

const escapeHTML = (value = "") => String(value).replace(/[&<>"']/g, (char) => ({ "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#039;" }[char]));
const formatDate = (date) => new Intl.DateTimeFormat("en", { month: "short", day: "numeric", year: "numeric" }).format(new Date(date));

document.addEventListener("DOMContentLoaded", () => {
  window.schoolWebsite = new SchoolWebsite();
});
