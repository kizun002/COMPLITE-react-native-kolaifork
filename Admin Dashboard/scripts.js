function showSection(sectionId) {
    const sections = document.querySelectorAll('.dashboard-card');
    sections.forEach(section => section.style.display = 'none');
    document.getElementById(sectionId).style.display = 'block';
}

function showReportResponse(reportId, title, description, date) {
    document.getElementById('responseArea').style.display = 'block';
    document.getElementById('reportId').textContent = reportId;
    document.getElementById('reportTitle').textContent = title;
}

function submitResponse() {
    const responseText = document.getElementById('responseText').value;
    alert(`Response submitted: ${responseText}`);
    document.getElementById('responseText').value = "";
    document.getElementById('responseArea').style.display = 'none';
}
