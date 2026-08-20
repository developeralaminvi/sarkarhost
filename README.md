# Sarkar Host - Modern Agency & IT Solutions WordPress Theme

**Version**: 1.4.1  
**Author**: Sarkar Host Team  
**Website**: [sarkarhost.com](https://sarkarhost.com/)  
**License**: GPL v2 or later  

**Sarkar Host** is a premium, high-performance, responsive WordPress theme specifically crafted for IT companies, web hosting providers, digital marketing agencies, SEO consultants, software houses, and corporate organizations.

---

## 🚀 Key Features

- ⚡ **Ultra-fast & Lightweight**: Built with pure semantic PHP, vanilla modern JavaScript, and optimized CSS (zero heavy bloated frameworks).
- 🎨 **Global Color System & 1-Click Theme Presets (v1.4.1)**:
  - Full variable-based `:root` design architecture supporting custom brand palettes.
  - **1-Click Clean White Theme (Light Mode)**: Pure white background with deep charcoal/slate typography and crisp modern borders.
  - **1-Click Nordic Frost (Pearl Light)**, **Cyber Tech (Dark)**, **Midnight Sapphire**, **Emerald Matrix**, **Royal Cyberpunk**, and **Sunset Crimson** presets.
  - Live interactive real-time preview inside WP Admin Theme Settings.
- 📱 **Ergonomic Mobile-First Optimization**:
  - **Clean Mobile Header**: Only brand logo and sleek Hamburger Menu icon `[ ☰ ]` on the top bar.
  - **Comprehensive Slide-In Drawer**: Contains brand header with close button `[ ✕ ]`, full navigation with smooth accordion submenus, full-width "যোগাযোগ করুন ➜" CTA button, direct 1-click **Call** & **WhatsApp** quick buttons, and office/support address info card.
  - **Optimized Typography & Spacing**: Proportionally tuned heading sizes, tighter section paddings, compact card paddings, and thumb-friendly touch targets on all mobile and tablet screens.
- 🛡️ **Anti-Spam & Real-time Phone Validation**:
  - **Live Bangladeshi Mobile Number Validation**: Checks valid 11-digit format (`013, 014, 015, 016, 017, 018, 019`) in real-time as the user types, displaying instant Bengali feedback and shake animations on invalid inputs.
  - **Spam Link & URL Blocker**: Blocks spam links, domains (`http`, `https`, `.com`, `t.me/`, `bit.ly/`, etc.) from being submitted.
  - **Honeypot Bot Protection**: Silent bot trap to filter out automated submission spam.
- 📨 **Leads & Inquiries Dashboard (WP Admin)**:
  - Automatically captures inquiries from Service Modals, Contact Pages, and Contact Form 7.
  - Real-time unread notification badge in WordPress Admin sidebar.
  - Direct 1-click **WhatsApp Chat** (`wa.me`) with pre-filled greeting and **Call** (`tel:`) buttons per lead.
  - Status management (`New`, `Contacted`, `Confirmed`) and 1-click CSV export.
- 📧 **Admin HTML Email Notifications**: Sends modern, branded HTML emails to the administrator upon form submission with client details and instant response buttons.
- 🌟 **Dynamic Active Menu Indicator**: Glowing lime underline indicator for the current page and parent service dropdown item.
- ⚙️ **Smart Theme Settings Control Panel**: Manage branding colors, office addresses, phone numbers, WhatsApp, map links, and copy shortcodes with 1 click.

---

## 📂 Theme Structure

```text
sarkarhost/
├── assets/
│   ├── css/
│   ├── js/
│   │   └── theme-script.js
│   └── images/
├── inc/
│   ├── shortcodes.php
│   └── theme-settings.php
├── footer.php
├── functions.php
├── header.php
├── index.php
├── page.php
├── style.css
├── template-home.php
├── template-seo.php
├── template-web.php
├── template-hosting.php
├── template-marketing.php
├── template-graphics.php
└── template-contact.php
```

---

## 🛠️ Installation & Setup

1. Upload the `sarkarhost` folder to your `/wp-content/themes/` directory.
2. Activate the theme via **WordPress Admin > Appearance > Themes**.
3. Configure your details in **Sarkar Host Settings** in the WordPress Admin sidebar.

---

## 📄 Changelog

### Version 1.4.1
- **Hero WhatsApp CTA Button Contrast**: Fixed `.btn-glass` background and text color to dynamic `var(--bg-surface)` and `var(--text-main)` with crisp border and WhatsApp brand green icon for flawless visibility in light & dark modes.
- **Navbar Dropdown Menu Contrast**: Fixed desktop dropdown menu background from hardcoded dark slate to dynamic `var(--bg-surface)` with high-contrast text and adaptive active states for Clean White & Light modes.
- **6-Step SEO Process Section Contrast**: Fixed `.seo-spotlight-wrapper` dark gradient background to dynamic `var(--bg-dark-secondary)` and `var(--border-color)` ensuring complete readability of "আমাদের প্রমাণিত ৬-ধাপের SEO Process" in white/light versions.
- **Fixed White-on-White Inline Heading Colors**: Replaced hardcoded `var(--text-white)` with dynamic `var(--text-main)` on "কেন আমাদের SEO Service নেবেন?" and "সরাসরি মেসেজ পাঠান" (Contact Form) headings.
- **Contact Form 7 & Input Controls**: Updated CF7 input elements to use dynamic card backgrounds and main text colors.

### Version 1.4.0
- **1-Click Light / White Mode Preset**: Added instant 1-click Clean White and Nordic Frost palettes in Theme Settings.
- **Universal Color & Contrast System**: Converted all hardcoded CSS colors to dynamic `:root` CSS variables (`var(--bg-dark)`, `var(--text-main)`, `var(--bg-surface)`, `var(--border-color)`).
- **Interactive Live Preview in WP Admin**: Real-time interactive miniature preview of header, buttons, and service cards when changing color options or picking presets.
- **Fixed White-on-White Contrast**: Fixed hero title, footer social icons, mobile drawer actions, dropdown menus, and metric numbers for flawless light and dark mode presentation.

### Version 1.2.0
- **Mobile UI Overhaul**: Streamlined mobile header bar with Logo + Hamburger toggle only.
- **Mobile Menu Drawer**: Added top close button, full navigation accordion, full-width CTA button, quick action Call/WhatsApp buttons, and contact card.
- **Mobile Spacing & Typography**: Reduced vertical section paddings, optimized card paddings, and tuned heading font sizes (`1.65rem` - `1.85rem`) for maximum readability on mobile devices.
- **Real-time Bangladeshi Phone Validation**: Live inline Bengali feedback, shake animation on error, and strict 11-digit mobile validation (`013-019`).
- **Anti-Spam Link Blocker**: Automated link and URL blocking across all input fields.
- **Admin Email Notifications**: Added responsive HTML email dispatch on form submissions.
