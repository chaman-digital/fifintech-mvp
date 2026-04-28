# Design System (GBM Aesthetic)

## Typography
- **Primary Font:** `Inter`, sans-serif
- **Weights:** 
  - Headings: `700` (Bold), `800` (Extra Bold)
  - Body: `400` (Regular), `500` (Medium)
- **Tracking:** Tighter tracking on large headings (`tracking-tight`), normal on body.

## Colors (Tailwind Tokens)
- **Backgrounds:**
  - `bg-white` (`#FFFFFF`) for clean, spacious sections.
  - `bg-[#0A0A0A]` or `bg-black` for high-contrast dark sections (Footer, Hero optional).
  - `bg-gray-50` (`#F9FAFB`) for subtle card backgrounds.
- **Text:**
  - `text-black` (`#000000`) for primary headings.
  - `text-gray-600` (`#4B5563`) for secondary text.
  - `text-white` on dark backgrounds.
- **Accents (GBM & Shield Fusion):**
  - Shield/Crypto Accent: `text-blue-600` (`#2563EB`) or `text-emerald-500` (`#10B981`) for success/USDT.
  - Highlighting: Use subtle gradients `bg-gradient-to-r from-gray-900 to-gray-700`.

## UI Elements & Borders
- **Buttons:**
  - Primary: `bg-black text-white rounded-full px-6 py-3 font-medium hover:bg-gray-800 transition-colors`.
  - Secondary: `bg-white text-black border border-gray-200 rounded-full px-6 py-3 font-medium hover:bg-gray-50`.
- **Cards:**
  - Large border radii: `rounded-3xl`.
  - Borders: Very subtle `border border-gray-100`.
  - Shadow: Soft, barely visible `shadow-sm` or `shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)]`.

## Special Effects (Project Rules)
- **Glassmorphism (Navigation):**
  - `backdrop-filter: blur(10px) saturate(180%);`
  - `background-color: rgba(255, 255, 255, 0.5);`
  - `border: 1px solid rgba(209, 213, 219, 0.3);`
- **Progressive Blur (Headers):**
  - `filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));` or custom progressive mask in CSS.

## Breakpoints
- Standard Tailwind breakpoints (`sm`, `md`, `lg`, `xl`).
- High emphasis on `px-4 md:px-8 lg:px-12` padding to create massive white space (GBM style).
