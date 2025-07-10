const nav = `  <img src="res/cat-removebg-preview.png" alt="logo">
        <h1>S4 Store</h1>
        <ul>
            <li>games</li>
            <li>apps</li>
            <li>scripts</li>
        </ul>
        <input type="text" placeholder="search">
        <p>?help</p>
        <p>profile</p>`;
const footer = `   <div class="footer-container">
            <div class="footer-section">
                <h4>Handy Links</h4>
                <div class="footer-item">Home</div>
                <div class="footer-item">Contact</div>
                <div class="footer-item">Help</div>
                <div class="footer-item">Feedback</div>
            </div>
            <div class="footer-section">
                <h4>Social Links</h4>
                <div class="footer-item">GitHub</div>
                <div class="footer-item">LinkedIn</div>
                <div class="footer-item">YouTube</div>
                <div class="footer-item">Twitter</div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>SOFAI 4H © 2025 4H ARABIC. All rights reserved.</p>
        </div>
    `;

const navElement = document.querySelector('nav');
const footerElement = document.querySelector('footer');
navElement.innerHTML = nav;
footerElement.innerHTML = footer;

