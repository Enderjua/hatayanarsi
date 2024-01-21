const tagContainer = document.querySelector("#tag-container");
const tagInput = document.querySelector("#mekanEtiketler");

tagInput.addEventListener("keyup", function(event) {
    if (event.key === "," || event.key === "Enter") {
        const tagValue = tagInput.value.trim().replace(",", "");
        if (tagValue) {
            createTag(tagValue);
            tagInput.value = "";
        }
    }
});

function createTag(value) {
    const tag = document.createElement("div");
    tag.className = "tag";

    const tagText = document.createElement("span");
    tagText.innerText = value;
    tag.appendChild(tagText);

    const tagClose = document.createElement("span");
    tagClose.innerText = "x";
    tagClose.className = "tag-close";
    tagClose.addEventListener("click", function() {
        tagContainer.removeChild(tag);
    });

    tag.appendChild(tagClose);
    tagContainer.insertBefore(tag, tagInput);
}
