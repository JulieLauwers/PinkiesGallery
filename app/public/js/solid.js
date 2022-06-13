// ... import statement for authentication, which includes the fetch function, is omitted for brevity.

import { readFile } from 'fs/promises';
import { saveFileInContainer, getSourceUrl } from "@inrupt/solid-client";

const MY_POD_URL = "https://pinkie.solidcommunity.net/";

const session = new Session();

// ... Various logic, including login logic, omitted for brevity.

if (session.info.isLoggedIn) {
  readAndSaveFile('../ZonStrandZee.jpg', "image/jpeg", `${MY_POD_URL}PinkiesGallery/`, "mypigeon.jpg", session.fetch);
  //readAndSaveFile('./report.pdf', "application/pdf", `${MY_POD_URL}mypdfs/`, "myreport.pdf", session.fetch);
}

// ...

// Read local file and upload into a Container
async function readAndSaveFile(filepath, mimetype, containerURL, slug, fetch) {
  
  try {
    const data = await readFile(filepath);
    placeFileInContainer(data, mimetype, containerURL, slug, fetch);
  } catch (err) {
    console.log(err);
  }
}

// Upload data as a file into the targetContainer.
async function placeFileInContainer(filedata, mimetype, targetContainerURL, slug, fetch) {
  try {
    const savedFile = await saveFileInContainer(
      targetContainerURL,           // Container URL
      filedata,                     // Buffer containing file data
      { slug: slug, contentType: mimetype, fetch: fetch }
    );
    console.log(`File saved at ${getSourceUrl(savedFile)}`);
  } catch (error) {
    console.error(error);
  }
}