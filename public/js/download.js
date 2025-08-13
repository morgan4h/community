console.log("starting...");

fetch("/apps")
  .then((res) => {
    if (!res.ok) {
      throw new Error(`HTTP error! Status: ${res.status}`);
    }
    return res.json();
  })
  .then((data) => {
    for (const app in data) {
      if (data[app].id == location.search.slice(5)) {
        // console.log("Fetched data:", data[app].id);
        console.log(data[app])
        let appTitle = document.querySelector('.app-title')
        appTitle.textContent = data[app].name
        document.querySelector('.app-header img').src = data[app].img
        // document.querySelector('img').alt = data[app].img
        document.querySelector('.install-btn').onclick = function() {
            location.href = data[app].link_for_download
        }

        document.querySelector('.about-section').textContent = data[app].about_app
        document.querySelector('.app-subtitle').textContent = data[app].description_short
      }
    }
  });
