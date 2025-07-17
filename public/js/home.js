console.log("home started.");

fetch("/apps")
  .then((res) => {
    if (!res.ok) {
      throw new Error(`HTTP error! Status: ${res.status}`);
    }
    return res.json();
  })
  .then((data) => {
    // console.log("Fetched data:", data);

    const container = document.querySelector(".imgs");

    if (!Array.isArray(data)) {
      console.error("Fetched data is not an array.");
      return;
    }
    if (!container) {
      console.error("Container with class '.imgs' not found in the DOM.");
      return;
    }

    const startIndex = Math.max(0, data.length - 6);

    for (let i = startIndex; i < data.length; i++) {
      const app = data[i];

    //   console.log("Processing app:", app);
    //   console.log("Container element:", container);

      const imgsNodeDiv = document.createElement("div");
      imgsNodeDiv.classList.add("imgs-node");
      imgsNodeDiv.id = `app-${app.id}`;

      const imgElement = document.createElement("img");
      imgElement.src = app.img;
      imgElement.alt = app.id;

      const titleParagraph = document.createElement("p");
      titleParagraph.textContent = app.name;

      const priceParagraph = document.createElement("p");
      priceParagraph.textContent = app.price;

      imgsNodeDiv.appendChild(imgElement);
      imgsNodeDiv.appendChild(titleParagraph);
      imgsNodeDiv.appendChild(priceParagraph);

      container.appendChild(imgsNodeDiv);
    }
  })
  .catch((error) => {
    console.error("Error fetching data:", error);
  });



//   all the apps

const allAppsContainer = document.querySelector(".the-apps-list");
const seeMoreButton = document.querySelector(".all-app button");

const appsPerPage = 9;
let currentPage = 0;
let totalAppsData = [];
let clickCount = 0;

function renderApps(appsToDisplay) {
  appsToDisplay.forEach(app => {
    const appDiv = document.createElement('div');
    appDiv.classList.add('app');
    appDiv.id = `app-${app.id}`;

    const imgElement = document.createElement('img');
    imgElement.src = app.img;
    imgElement.alt = app.id;

    const titleParagraph = document.createElement('p');
    titleParagraph.textContent = app.name;

    const priceParagraph = document.createElement('p');
    priceParagraph.textContent = app.price;

    appDiv.appendChild(imgElement);
    appDiv.appendChild(titleParagraph);
    appDiv.appendChild(priceParagraph);

    allAppsContainer.appendChild(appDiv);
  });
}

function updateSeeMoreButtonText() {
  const appsDisplayed = currentPage * appsPerPage;
  if (appsDisplayed >= totalAppsData.length && totalAppsData.length > 0) {
    seeMoreButton.textContent = "Back to first page";
  } else {
    seeMoreButton.textContent = `See more (${clickCount})`;
  }
}

function loadNextApps() {
  if (currentPage * appsPerPage >= totalAppsData.length && totalAppsData.length > 0) {
    allAppsContainer.innerHTML = '';
    currentPage = 0;
    clickCount = 0;
  }

  const startIndex = currentPage * appsPerPage;
  const endIndex = Math.min(startIndex + appsPerPage, totalAppsData.length);

  const appsToLoad = totalAppsData.slice(startIndex, endIndex);

  renderApps(appsToLoad);

  currentPage++;
  clickCount++;

  updateSeeMoreButtonText();
}

fetch("/apps")
  .then((res) => {
    if (!res.ok) {
      throw new Error(`HTTP error! Status: ${res.status}`);
    }
    return res.json();
  })
  .then((data) => {
    console.log("Fetched data:", data);
    totalAppsData = data;

    loadNextApps();

    if (seeMoreButton) {
      seeMoreButton.addEventListener('click', loadNextApps);
      updateSeeMoreButtonText();
    } else {
      console.error("See More button not found!");
    }

  })
  .catch((error) => {
    console.error("Error fetching data:", error);
  });


  document.addEventListener('click', function(e) {
    if(e.target.alt == undefined) {
        // console.log('no att')
    }else {
        console.log(e.target.alt)
        location.href = `/download/?app=${e.target.alt}`;
    }
  })