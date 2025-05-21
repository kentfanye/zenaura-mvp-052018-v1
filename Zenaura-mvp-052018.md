# Zenaura.club - Personalized Feng Shui Wallpaper Website - Project Plan

## 【Website Synopsis】

Zenaura.club helps Western users enhance their luck by providing personalized Feng Shui mobile wallpapers based on their BaZi (Four Pillars of Destiny) birth chart.

## 【Core Design Philosophy】

Clean, modern, trustworthy, and intuitive. The design will use a calming color palette (e.g., soft blues, greens, earthy tones, with gold accents for a premium feel) and high-quality visuals. Typography will be clear and legible. The website will be entirely in English.

---

## I. Website Structure & User Flow (Page by Page)

Each step in the user flow will correspond to a distinct page for clarity in this MVP.

### Page 0: Homepage (`index.php`)

*   **Purpose:** Immediately communicate what Zenaura.club offers and build trust.
*   **Key Elements:**
    *   **Headline (H1):** `Unlock Your Luck: Get Your Personalized Feng Shui Wallpaper`
    *   **Sub-headline (H2):** `Discover the ancient secret to enhancing your fortune with custom wallpapers designed from your unique birth chart (BaZi).`
    *   **Hero Section:**
        *   Visually appealing, serene, and slightly mystical background image.
        *   **CTA Button:** `"Get Your Personalized Wallpaper Now"` (Links to `step1_birth_input.php`)
    *   **How It Works (Brief Section):**
        1.  `Enter Your Birth Details: We calculate your unique BaZi chart.`
        2.  `See Your Elemental Profile: Understand your core energies.`
        3.  `Choose Your Lucky Wallpaper: Select from AI-curated designs.`
        4.  `Boost Your Fortune: Download and set your new wallpaper.`
    *   **User Testimonials Section:**
        *   **Title:** `"See What Our Users Are Saying..."`
        *   **Content Examples (to be presented in a visually appealing way):**
            *   `"I was skeptical at first, but after changing my wallpaper, I landed a new job within a week! The positive energy is undeniable." - Sarah K.`
            *   `"My relationships have improved, and I feel more confident. Zenaura.club's wallpaper made a real difference." - Mike B.`
            *   `"Things just started flowing my way. Opportunities I never expected! This is more than just a pretty picture." - Emily L.`
            *   `"I've always been interested in Feng Shui. Zenaura made it so easy to apply it to my daily life. My stress levels are down, and good things are happening!" - David R.`
    *   **Footer:** `Copyright Zenaura.club`, (Optional: Privacy Policy, Terms of Service links).

### Page 1: Birth Details Input (`step1_birth_input.php`)

*   **Purpose:** Collect user's birth date and time.
*   **Key Elements:**
    *   **Title:** `Enter Your Birth Information`
    *   **Form Fields (POST to `step2_dashboard.php`):**
        *   `birth_year` (YYYY, e.g., 1988)
        *   `birth_month` (MM, dropdown 01-12)
        *   `birth_day` (DD, dropdown 01-31)
        *   `birth_hour_slot` (Dropdown for Hour, 00-23, representing the start of a 1-hour slot)
            *   *Note: Server-side will map this to the correct 2-hour BaZi Shi Chen.*
        *   *Client-side JavaScript validation for valid date recommended.*
    *   **Information/Disclaimer:** `"Please provide your accurate birth date and time for the most precise BaZi calculation. We respect your privacy."`
    *   **CTA Button:** `"Calculate My BaZi Chart"`

### Page 2: BaZi & Five Elements Dashboard (`step2_dashboard.php`)

*   **Purpose:** Display calculated BaZi and Five Elements analysis.
*   **Backend Logic (On Load):**
    1.  Receive YYYY, MM, DD, Hour from `$_POST`.
    2.  Call LLM Function 1 (DOB to BaZi).
    3.  Call LLM Function 2 (BaZi to Five Elements Analysis).
*   **Key Elements:**
    *   **Title:** `Your Personalized Feng Shui Dashboard`
    *   **Section 1: Your BaZi Chart (生辰八字)**
        *   Display Four Pillars (Year, Month, Day, Hour) with Stem & Branch (Chinese Char + Pinyin).
        *   Highlight Day Master.
    *   **Section 2: Your Five Elements Analysis (五行风水)**
        *   Visual representation (e.g., bar chart, radar chart) of Wood, Fire, Earth, Metal, Water strength.
        *   Display percentage and assessment (e.g., "Wood: 65% (Strong)").
        *   **Summary Text (from LLM Function 2 output):** Concise explanation of elemental balance and what needs support.
    *   **CTA Button:** `"Generate My Lucky Wallpapers"` (Submits/links to `step3_wallpaper_selection.php`, passing BaZi/Element info, possibly via POST or SESSION).

### Page 3: Wallpaper Selection (`step3_wallpaper_selection.php`)

*   **Purpose:** Allow user to select from AI-generated wallpapers.
*   **Backend Logic (On Load):**
    1.  Receive BaZi/Element info (or re-calculate if not passed efficiently).
    2.  Call LLM Function 3 (Elements to Wallpapers + Rationale).
*   **Key Elements:**
    *   **Title:** `Choose Your Feng Shui Wallpapers`
    *   **Instructions:** `"Our AI Feng Shui Master has designed these 5 wallpapers based on your unique BaZi. Select 1 to 5 wallpapers to boost your fortune."`
    *   **Display Area (Grid or Carousel):**
        *   Show 5 thumbnail images of wallpapers (placeholder URLs or actual image URLs if pre-generated).
        *   For each wallpaper:
            *   Checkbox for selection.
            *   Wallpaper Title (from LLM Function 3).
            *   Concise Feng Shui Rationale (from LLM Function 3).
    *   **Dynamic Price Display (JavaScript):**
        *   `"Number of wallpapers selected: [X]"`
        *   `"Total Price: $[Y]"` (Define pricing tiers, e.g., 1 for $9.99, 2 for $17.99, etc.)
    *   **CTA Button:** `"Proceed to Get My Wallpapers"` (Submits selected wallpaper choices/count to `step4_contact_payment.php`).

### Page 4: "Payment" / Contact (`step4_contact_payment.php`)

*   **Purpose:** MVP "payment" step - guide user to contact via WeChat/WhatsApp.
*   **Backend Logic (On Load):**
    1.  Receive selected wallpaper count/IDs from `$_POST`.
*   **Key Elements:**
    *   **Title:** `Complete Your Order & Connect`
    *   **Order Summary:** `"You have selected [X] wallpaper(s)."`
    *   **Total Price:** `"Price: $[Y]"`
    *   **Instructions:**
        *   `"To receive your personalized wallpapers, please connect with our Feng Shui Assistant."`
        *   `"Scan the QR code below to add our assistant on WeChat or WhatsApp."`
        *   `"Once connected, please mention 'Zenaura Wallpaper Order' and our assistant will guide you through the final steps and send you your downloads."`
    *   **QR Code Display:**
        *   WeChat QR code image.
        *   WhatsApp QR code image (or `wa.me/<phonenumber>` link).
    *   **Information:** `"After confirmation from our assistant, you will be able to select your phone model and download your wallpapers."`
    *   **CTA Button:** `"I've Contacted the Assistant / Proceed to Phone Selection"` (Links to `step5_download_prep.php`).

### Page 5: Phone Model Selection & "Download" (`step5_download_prep.php`)

*   **Purpose:** User selects phone model for wallpaper sizing and placeholder "download" step.
*   **Backend Logic (On Load):**
    1.  (Potentially retrieve selected wallpaper details from SESSION or passed IDs).
*   **Key Elements:**
    *   **Title:** `Prepare Your Wallpapers for Download`
    *   **Instructions:** `"Select your phone model to ensure your wallpapers are perfectly sized. Download links will be activated once your connection with our assistant is confirmed."`
    *   **Form (POST to itself or a download handler if implementing actual resizing):**
        *   `phone_brand` (Dropdown: Apple, Samsung, Google, etc.)
        *   `phone_model` (Dropdown, dynamically populated or simplified to common aspect ratios for MVP).
            *   *MVP simplification: "Standard Smartphone (e.g., 1080x1920)", "Large Smartphone (e.g., 1440x2960)"*
    *   **"Download" Section (MVP Placeholder):**
        *   `"Your personalized wallpapers are being prepared. Our assistant will provide you with the download links via WeChat/WhatsApp shortly after confirming your order. Please ensure you have contacted them."`
        *   *(Optional: If image generation is integrated, and manual step is skipped, this is where actual download links for resized images would appear. For MVP, focus on assistant handoff).*
    *   **Thank You Message:** `"Thank you for choosing Zenaura.club! We wish you enhanced luck and prosperity."`

---

## II. LLM Function Prompts (Alibaba QWEN Model)

### Function 1: Calculate BaZi from Birth Details

*   **Purpose:** Convert DOB and Time into BaZi Four Pillars.
*   **Input:**
    *   `birth_date` (String: YYYYMMDD)
    *   `birth_hour_slot` (Integer: 0-23, representing the start of the 1-hour slot selected by user)
*   **Prompt for QWEN:**
    ```text
    You are an expert BaZi (Four Pillars of Destiny) calculator.
    Given the birth date: {birth_date}
    And the birth hour slot starting at: {birth_hour_slot}:00 local time.

    First, determine the correct 2-hour traditional Chinese "Shi Chen" (时辰) based on the provided 1-hour slot. For example, 00:00-00:59 is Zi hour, 01:00-02:59 is Chou hour, ..., 23:00-23:59 is Hai hour (or the start of the next day's Zi hour if the birth time is very close to midnight, be precise).

    Then, calculate the Four Pillars: Year, Month, Day, and Hour.
    For each pillar, provide:
    1. The Heavenly Stem (天干) in Chinese character and Pinyin.
    2. The Earthly Branch (地支) in Chinese character and Pinyin.

    Output the result in a structured JSON format like this:
    {
      "year_pillar": {"stem_char": "甲", "stem_pinyin": "Jia", "branch_char": "子", "branch_pinyin": "Zi"},
      "month_pillar": {"stem_char": "丙", "stem_pinyin": "Bing", "branch_char": "寅", "branch_pinyin": "Yin"},
      "day_pillar": {"stem_char": "庚", "stem_pinyin": "Geng", "branch_char": "午", "branch_pinyin": "Wu"},
      "hour_pillar": {"stem_char": "壬", "stem_pinyin": "Ren", "branch_char": "申", "branch_pinyin": "Shen"}
    }
    Ensure accuracy in all calculations, especially the hour pillar determination.
    ```

### Function 2: BaZi to Five Elements Strength Analysis

*   **Purpose:** Analyze BaZi to determine the strength of the Five Elements.
*   **Input:** `bazi_chart` (JSON object from Function 1 output).
*   **Prompt for QWEN:**
    ```text
    You are a Feng Shui master specializing in BaZi Five Element analysis.
    Given the following BaZi chart:
    {bazi_chart_json_string}

    Analyze the strength of the five elements (Wood, Fire, Earth, Metal, Water) for the Day Master (element of the Day Pillar's Heavenly Stem).
    Consider the supporting, weakening, and controlling relationships between elements in all four pillars, the season of birth (from the Month Pillar's Earthly Branch), and the strength of the Day Master itself.

    Output the analysis in a structured JSON format:
    {
      "elements_strength": [
        {"element_en": "Wood", "element_zh": "木", "strength_percentage": 0, "assessment": "Balanced"},
        {"element_en": "Fire", "element_zh": "火", "strength_percentage": 0, "assessment": "Balanced"},
        {"element_en": "Earth", "element_zh": "土", "strength_percentage": 0, "assessment": "Balanced"},
        {"element_en": "Metal", "element_zh": "金", "strength_percentage": 0, "assessment": "Balanced"},
        {"element_en": "Water", "element_zh": "水", "strength_percentage": 0, "assessment": "Balanced"}
      ],
      "day_master_element_en": "Element",
      "day_master_element_zh": "干",
      "overall_summary": "Provide a concise summary here highlighting strong, weak elements and suggested balancing approach for wallpaper design. Example: This chart indicates a strong Metal element, while Fire and Water are comparatively weak. The Day Master is Geng Metal. To enhance luck, focus on strengthening the Fire and Water elements."
    }
    The strength_percentage should be an integer between 0 and 100. The assessment can be 'Very Weak', 'Weak', 'Balanced', 'Strong', 'Very Strong'. The summary should be concise and actionable for wallpaper design.
    ```

### Function 3: Five Elements Analysis to Wallpaper Designs & Rationales

*   **Purpose:** Generate 5 wallpaper concepts (text-to-image prompts) and Feng Shui rationales.
*   **Input:** `five_elements_analysis` (JSON object from Function 2 output).
*   **Prompt for QWEN:**
    ```text
    You are a creative Feng Shui AI artist and consultant. Your task is to generate ideas for 5 unique mobile wallpapers tailored to a user's Five Element analysis, suitable for a Western audience (modern, abstract, nature-inspired, subtly symbolic rather than overtly traditional Chinese).
    The user's Five Element analysis is:
    {five_elements_analysis_json_string}

    For each of the 5 wallpapers, you must provide:
    1.  `title`: A catchy, descriptive title (e.g., "Serene Mountain Sunrise").
    2.  `image_generation_prompt`: A detailed textual prompt suitable for a text-to-image AI generator (like DALL-E 3, Midjourney, or Stable Diffusion). This prompt should describe the visual elements, colors, style, and mood, all aligned with Feng Shui principles to balance the user's elements. Emphasize elements that need strengthening and harmonious colors.
    3.  `feng_shui_rationale`: A concise explanation (2-3 sentences) in English of why this specific design is beneficial for the user, linking it back to their Five Element analysis (e.g., "This design uses warm sunrise colors (Fire) and stable mountain imagery (Earth) to nourish your weak Fire element and provide grounding, promoting career stability and recognition.").

    Output the result as a JSON array, with each element being an object for one wallpaper.
    The image_generation_prompt should aim for visually appealing, high-quality wallpaper designs.
    Example structure for one wallpaper object:
    {
      "title": "Emerald Forest Flow",
      "image_generation_prompt": "Mobile wallpaper, abstract digital art, flowing emerald green and teal patterns representing vibrant Wood and nourishing Water, accented with subtle hints of gold. Ethereal, calming, and growth-oriented. High resolution, detailed textures, 9:16 aspect ratio.",
      "feng_shui_rationale": "This wallpaper strengthens your Wood element with lush greens, symbolizing growth and vitality. The flowing teal (Water) nourishes Wood, enhancing career opportunities and personal development. Gold accents provide a touch of Metal for clarity."
    }
    Ensure variety across the 5 designs, focusing on the elements identified as weak or needing support in the analysis. Use English for all output fields.
    ```

---

## III. Technical Backend Notes (PHP)

### 1. Directory Structure (Example)

zenaura.club/
├── index.php # Homepage
├── step1_birth_input.php
├── step2_dashboard.php
├── step3_wallpaper_selection.php
├── step4_contact_payment.php
├── step5_download_prep.php
├── css/
│ └── style.css # Main stylesheet
├── js/
│ └── main.js # For dynamic pricing, form validation, AJAX if any
├── images/ # Site logos, static images, QR codes (wechat_qr.png, whatsapp_qr.png)
├── includes/
│ ├── config.php # API keys, database credentials (if any later)
│ ├── functions.php # General helper functions
│ └── qwen_api_client.php # Class/functions for QWEN LLM API interaction
├── generated_wallpapers/ # (Optional) Temporary storage for AI-generated images if directly handling
└── .htaccess # For clean URLs, security headers (optional for MVP)


### 2. Frontend Code

*   HTML5, CSS3. Keep it simple and clean.
*   Use semantic HTML.
*   JavaScript for client-side validation (dates, selections) and dynamic updates (price).

### 3. Backend Code (PHP)

*   **LLM API Calls:**
    *   Implement a robust function or class in `qwen_api_client.php` to handle API requests to Alibaba QWEN.
    *   Use cURL for making HTTP requests.
    *   Handle API responses, including error checking and parsing JSON.
    *   Store API key securely (e.g., in `config.php`, outside web root if possible, or environment variables).
*   **Data Passing Between Pages:**
    *   Primarily use `$_POST` for form submissions.
    *   Consider using `$_SESSION` to persist data across steps if complex data needs to be carried forward (e.g., BaZi results, element analysis) without re-querying or passing everything in hidden fields. Initialize sessions with `session_start();` at the top of each PHP file that needs session access.
*   **Image Handling (for Page 3 & 5):**
    *   **Page 3 (Wallpaper Display):** The LLM provides `image_generation_prompt`. For the MVP, you might:
        1.  Manually pre-generate some generic sample images based on common elemental needs and display these as placeholders.
        2.  If you have an image generation API (e.g., Qwen-VL-Max or another service), you could try to call it based on the prompt. For MVP, this might be too complex. The prompt is more for the "Feng Shui Master AI" to *design* it, with actual image generation being part of the "assistant's" fulfillment process for now.
        3.  For display, use symbolic placeholder images representing the elements or concepts.
    *   **Page 5 (Phone Model & Download):**
        *   The request is to adapt to specific phone model sizes.
        *   PHP's GD Library or ImageMagick extension will be needed if you are resizing images on the server.
        *   A mapping of phone models to resolutions would be required (can be simplified for MVP).
        *   **MVP approach:** Since actual payment and image delivery is manual via assistant, this step might just *collect* the phone model. The assistant then provides correctly sized images. If you want to automate this for a future version, the LLM-generated image would be a high-res master, then resized.
*   **Security:**
    *   Sanitize all user inputs (e.g., `htmlspecialchars()`, `filter_input()`) to prevent XSS.
    *   Validate inputs on server-side even if client-side validation exists.
*   **No Database for MVP:** Data is processed in-flight or via session. No user accounts.

### 4. Other MVP Considerations

*   **Error Handling:** Implement basic error handling for API calls and user input.
*   **Responsiveness:** Ensure the design is reasonably responsive for common mobile and desktop screen sizes using CSS media queries.
*   **Simplicity:** Keep features focused on the core user flow for the MVP. Avoid scope creep.

---
