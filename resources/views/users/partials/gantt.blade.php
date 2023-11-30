<div id="gantt-chart" style="width: 100%; height: 500px;"></div>
@vite('node_modules/dhtmlx-gantt/codebase/sources/dhtmlxgantt.css')
<script src="{{ Vite::asset('node_modules/dhtmlx-gantt/codebase/sources/dhtmlxgantt.js') }}"></script>
<script>
    const projectData = @json($userProjects);

    let taskGantt = [];
    const links = [];

    projectData.forEach(project => {
        const projectId = project.id;
        const projectName = project.name;

        taskGantt.push({
            id: projectId,
            text: projectName,
            start_date: project.startDate,
            duration: project.endDate - project.startDate,
            progress: 0.6, // Ajout de la propriété de progression
            open: true
        });
    });

    gantt.templates.task_cell_class = function(item, date) {
        if (date === item.start_date) {
            return "gantt-project-start";
        } else if (date === item.end_date) {
            return "gantt-project-end";
        }
        return "";
    };

    gantt.init("gantt-chart");
    gantt.config.date_format = "%d/%m/%Y";
    gantt.config.columns = [
        { name: "text", label: "Projet", width: "250", tree: true, resize: true },
        { name: "start_date", label: "Date début", width: "140", align: "center" },
        { name: "duration", label: "Durée", width: "50", align: "center" },
    ];
    gantt.parse({ data: taskGantt, links: links });
</script>