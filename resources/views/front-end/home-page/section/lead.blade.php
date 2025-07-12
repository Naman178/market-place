<style>
.popup-overlay {
  display: none;
  position: fixed;
  top: 0; left: 0;
  width: 100%; height: 100%;
  background: rgba(0, 0, 0, 0.6);
  z-index: 999;
  justify-content: center;
  align-items: center;
  padding: 20px;
  box-sizing: border-box;
}

.popup-box {
  display: flex;
  width: 900px;
  max-width: 100%;
  background: #fff;
  border-radius: 8px;
  overflow: hidden;
  position: relative;
  flex-direction: row;
}

/* Image section */
.popup-left {
  flex: 1;
}

.popup-left img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}

/* Content section */
.popup-right {
  flex: 1;
  padding: 30px;
  position: relative;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.popup-right h2 {
  font-size: 22px;
  margin-bottom: 10px;
}

.popup-right ul {
  padding-left: 18px;
  margin: 15px 0;
}

.popup-right ul li {
  margin-bottom: 8px;
}

.popup-right input[type="email"] {
  padding: 10px;
  margin-top: 10px;
  border: 1px solid #ccc;
  width: 100%;
  border-radius: 5px;
}

.popup-right button {
  background-color: #f8c45f;
  color: #000;
  padding: 10px;
  width: 100%;
  border: none;
  margin-top: 10px;
  border-radius: 5px;
  font-weight: bold;
  cursor: pointer;
}

.privacy-note {
  font-size: 12px;
  margin-top: 8px;
  text-align: center;
  color: #666;
}

.close-popup {
  position: absolute;
  top: 10px;
  right: 15px;
  font-size: 20px;
  cursor: pointer;
}

.popup-title {
  font-size: 24px;
  font-weight: bold;
  text-align: center;
  margin-bottom: 10px;
  line-height: 1.3;
}

.bullet-list {
  all: unset;
  list-style-type: disc;
  list-style-position: outside;
  padding-left: 30px;
  margin: 15px 0;
  display: block;
}

.bullet-list li {
  all: unset;
  display: list-item;
  list-style-type: disc;
  margin-bottom: 8px;
  color: #333;
}

/* ✅ Responsive Design */
@media (max-width: 768px) {
  .popup-box {
    flex-direction: column;
    width: 100%;
    height: auto;
  }

  .popup-left {
    display: none;
  }

  .popup-right {
    width: 100%;
    padding: 20px;
  }

  .popup-title {
    font-size: 20px;
  }

  .popup-right h2 {
    font-size: 18px;
  }

  .popup-right input[type="email"],
  .popup-right button {
    font-size: 14px;
  }

  .close-popup {
    top: 10px;
    right: 10px;
    font-size: 18px;
  }
}
</style>

<section class="lead-magnet">
  <div class="lead-magnet-container container">
    <!-- Left Column: Image -->
    <div class="lead-magnet-image">
      <img src="https://market-place-main.infinty-stage.com/storage/sub_category_images/6855390d68dfd_avada.png" alt="Free Lightweight WordPress Plugin Preview" />
    </div>

    <!-- Right Column: Content -->
    <div class="lead-magnet-content">
        <p class="plugin-label">
            <span class="label-line"></span> Free Resource
        </p>
        <h3>Claim a Free WordPress Plugin ($19 Value)</h3>
        <p>Subscribe now to receive instant access to our lightweight WordPress plugin — absolutely free.</p>
        <a class="white_btn d-inline-block today" href="javascript:void(0)" id="openPopup">
          <span>Claim Free Plugin</span>
          <img class="know_arrow" src="https://market-place-main.infinty-stage.com/front-end/images/up-right-arrow-dark.png" alt="Button Arrow">
        </a>
    </div>
  </div>
</section>

<div id="popup" class="popup-overlay">
  <div class="popup-box">
    <!-- Left: Image -->
    <div class="popup-left">
      <img src="https://market-place-main.infinty-stage.com/storage/sub_category_images/6855390d68dfd_avada.png" alt="Popup Image" />
    </div>

    <!-- Right: Content -->
    <div class="popup-right">
      <span class="close-popup" id="closePopup">&times;</span>

      <!-- Updated Title -->
      <h2 class="popup-title">
        Become a Privileged Customer
      </h2>

      <p>Join our exclusive circle and be the first to enjoy.</p>
      <ul class="bullet-list">
        <li>Early access to dazzling new collections</li>
        <li>Special promotions offers</li>
        <li>VIP invites to exclusive store events</li>
      </ul>
      <form id="newsletterForm">
        @csrf
        <input type="email" name="email" placeholder="Email" />
        <button type="submit" id="joinNowBtn">JOIN NOW →</button>
      </form>

      <!-- Centered Privacy Note -->
      <p class="privacy-note">We respect your privacy. No spam ever.</p>
    </div>
  </div>
</div>

<script>
var isSubscribed = @json($is_subscribed ?? false);
console.log(isSubscribed);
document.addEventListener("DOMContentLoaded", function () {
    const popup = document.getElementById('popup');
    const openBtn = document.getElementById('openPopup');
    const closeBtn = document.getElementById('closePopup');

    // Cookie helpers
    function setCookie(name, value, days) {
        const expires = new Date();
        expires.setTime(expires.getTime() + (days * 24 * 60 * 60 * 1000));
        //  expires.setTime(expires.getTime() + (days * 60 * 1000));
        document.cookie = name + "=" + value + ";expires=" + expires.toUTCString() + ";path=/";
    }

    function getCookie(name) {
        const decodedCookie = decodeURIComponent(document.cookie);
        const cookies = decodedCookie.split(';');
        for (let i = 0; i < cookies.length; i++) {
            let c = cookies[i].trim();
            if (c.indexOf(name + "=") === 0) {
                return c.substring(name.length + 1, c.length);
            }
        }
        return null;
    }

    // ✅ Auto-show popup if cookie not set
    if (!getCookie('popup_shown')  && !isSubscribed ) {
        setTimeout(() => {
            popup.style.display = 'flex';
            setCookie('popup_shown', 'yes', 1); // Set cookie for 1 day
        }, 7000);
    }

    // ✅ Always allow manual open
    openBtn.addEventListener('click', () => {
        popup.style.display = 'flex';
    });

    // Close logic
    closeBtn.addEventListener('click', () => {
        popup.style.display = 'none';
    });

    window.addEventListener('click', (e) => {
        if (e.target.id === 'popup') {
            popup.style.display = 'none';
        }
    });
});
</script>

<script>
  
document.getElementById('openPopup').addEventListener('click', function () {
  document.getElementById('popup').style.display = 'flex';
});

document.getElementById('closePopup').addEventListener('click', function () {
  document.getElementById('popup').style.display = 'none';
});

window.addEventListener('click', function (e) {
  if (e.target.id === 'popup') {
    document.getElementById('popup').style.display = 'none';
  }
});
</script>

<script>
  $(document).ready(function () {
    $('#newsletterForm').on('submit', function (e) {
      e.preventDefault();

      const email = $(this).find('input[name="email"]').val();
      const $btn = $('#joinNowBtn');
      const originalText = $btn.html();

      // Disable button and show processing text
      $btn.prop('disabled', true).html('Processing...');

      $.ajax({
        url: '{{ route("newsletter-add") }}',
        type: 'POST',
        data: {
          _token: '{{ csrf_token() }}',
          email: email
        },
        success: function (response) {
          toastr.success('Successfully subscribed!');
          $('#newsletterForm')[0].reset();
          $('#popup').hide();
        },
        error: function (xhr) {
          // Handle validation error
          if (xhr.status === 422) {
            const errors = xhr.responseJSON.errors;
            if (errors.email) {
              toastr.error(errors.email[0]);
            }
          }

          // Handle duplicate entry (conflict)
          else if (xhr.status === 409) {
            toastr.error(xhr.responseJSON.message); // <- This will now show your custom message
          }

          // Handle other errors
          else {
            toastr.error('Something went wrong. Please try again.');
          }
        },
        complete: function () {
          // Always re-enable the button
          $btn.prop('disabled', false).html(originalText);
        }
      });
    });
  });
</script>
