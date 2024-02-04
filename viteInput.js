const fs = require("fs");
const path = require("path");

function getAllStaticFiles(directory, extension) {
    let staticFiles = [];

    function traverseFolder(currentDir) {
        const files = fs.readdirSync(currentDir);

        files.forEach((file) => {
            const filePath = path.join(currentDir, file);
            const stats = fs.statSync(filePath);

            if (stats.isDirectory()) {
                // If it's a directory, recursively traverse it
                traverseFolder(filePath);
            } else if (path.extname(filePath) === extension) {
                // If it's a CSS file, add it to the list
                staticFiles.push(filePath);
            }
        });
    }

    traverseFolder(directory);

    return staticFiles;
}

const jsFolderPath = "./resources/js";
const cssFolderPath = "./resources/css";

// Get the js and css files in the resources folder
export default () => {
    const viteInput = {
        js: getAllStaticFiles(jsFolderPath, ".js"),
        css: getAllStaticFiles(cssFolderPath, ".css"),
    };

    return viteInput;
};
