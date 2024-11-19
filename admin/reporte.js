function filterByRole() {
    const role = document.getElementById('role-filter').value;
    loadTableData(role);
}

window.onload = () => loadTableData('');