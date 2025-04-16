<footer class="footer">
    <div class="footer-content">
        <div class="footer-left">
            <h4>Contact Us</h4>
            <p>National Council for Higher Education</p>
            <p>Area 47 Msokera Street<br>
                Next to Chitukuko Petroda Filling Station<br>
                Private Bag B371<br>
                Lilongwe Malawi</p>
            <p>Phone: +265 111 755 884</p>
            <p>Email: <a href="mailto:info@nche.ac.mw" class="footer-link">:info@nche.ac.mw</a></p>
        </div>

        <div class="footer-right">
            <h4>Quick Links</h4>
            <ul>
                <li><a href="/" class="footer-link">Home</a></li>
                <li><a href="/about" class="footer-link">About Us</a></li>
                <li><a href="/contact" class="footer-link">Contact</a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        &copy; {{ date('Y') }} NCHE. All rights reserved.
    </div>
</footer>

<style>
    .footer {
        background-color: #52074f;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 10px;
        box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
        margin-top: 2rem;
    }

    .footer-content {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        max-width: 1200px;
        margin: 0 auto;
    }

    .footer-left, .footer-right {
        flex: 1 1 300px;
        margin-bottom: 0.5rem;
    }

    .footer h4 {
        color: #dd8027;
        margin-bottom: 0.5rem;
        font-size: 1rem;
    }

    .footer p, .footer li {
        font-size: 0.85rem;
        margin: 0.2rem 0;
    }

    .footer-link {
        color: #fff;
        text-decoration: none;
        transition: color 0.3s ease;
        font-size: 0.85rem;
    }

    .footer-link:hover {
        color: #dd8027;
    }

    .footer-bottom {
        text-align: center;
        margin-top: 0.5rem;
        font-size: 0.75rem;
        border-top: 1px solid #ccc;
        padding-top: 0.5rem;
    }
</style>
