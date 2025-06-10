let allProducts = [];
let filterProducts = [];
let currentPage = 1;
const BY_PAGE = 9;

function loadProducts() {
    fetch('../ajax/Products.php')
    .then(res => res.json())
    .then( products => {
        allProducts = products;
        filterProducts = products;
        
        renderProducts();
        addListeners();
    })
    .catch(err=>console.error("Error to load products: ", err));
}

function addListeners() {
    const searchInput = document.getElementById("search-input");

    if(searchInput) {
        document.querySelectorAll("[id^='price-']").forEach(cb => {
            cb.addEventListener("change", applyFilters());
    });
}

function applyFilters() {
    const search = document.getElementById("search-input")?.value.toLowerCase()||"";
    const prices = Array.from(document.querySelectorAll("[id^='price-']:checked")).map(cb => cb.id);
}

function renderProducts() {

}