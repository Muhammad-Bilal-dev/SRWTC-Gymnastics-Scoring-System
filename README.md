# SRWTC-Gymnastics-Scoring-System
A real-time scoring system for SRWTC gymnastics events. Judges can enter scores for gymnasts, data is stored in Google Sheets, and a live results subdomain displays overall scores. The system also handles duplicate gymnast numbers with an overwrite confirmation option.

**🔗 Live Scoring Links:**  
- [Floor Scoring](https://floor.srwtc.com/)  
- [Vault Scoring](https://vault.srwtc.com/)  
- [Bars Scoring](https://bars.srwtc.com/)  
- [Range Scoring](https://range.srwtc.com/)  

**📊 Live Results:**  
- [Overall Results](https://results.srwtc.com/)  

---

## Tech Stack
- **Frontend:** HTML5, CSS3, Bootstrap 5, Vanilla JavaScript  
- **Backend:** PHP (Form handling, API endpoints, overwrite logic)  
- **Database / Storage:** Google Sheets (via Google Sheets API / Service Account)  
- **Hosting:** PHP-enabled web server (Apache or Nginx with PHP-FPM)  
- **Other Tools:**  
  - Fetch API for AJAX requests  
  - Bootstrap Modals for confirmations & overwrite prompts  
  - JSON-based payloads for frontend–backend communication  

---

## Features
- 📝 Judges can input scores by gymnast number  
- 🔄 Duplicate gymnast numbers trigger an overwrite confirmation  
- 📊 All scores are saved automatically to Google Sheets  
- 🌐 Dedicated subdomains for each event + a live results site  
- ✅ Responsive, mobile-friendly UI with Bootstrap 5  

---

## How to Run
1. Install a PHP-enabled web server (e.g., XAMPP, MAMP, or WAMP)  
2. Place this folder in the server’s root directory (`htdocs` for XAMPP)  
3. Configure Google Sheets API credentials inside `submit-scores.php`  
4. Start the server and open `http://localhost/your-folder-name` in a browser  

---

## License
MIT License
