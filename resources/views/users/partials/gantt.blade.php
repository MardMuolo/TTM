<div id="gantt-chart" style="width: 100%; height: 500px;"></div>
<script src="https://cdn.jsdelivr.net/npm/dhtmlx-gantt@8.0.6/codebase/dhtmlxgantt.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dhtmlx-gantt@8.0.6/codebase/dhtmlxgantt.min.css">
{{-- <script>
    const projectData = @json($userProjects);
    console.log("date", projectData)

    let taskGantt = [];
    const links = [];

    projectData.forEach(project => {
        let projectId = project.id;
        let projectName = project.name;
        let projectStartDate = project.startDate;
        let projectEndDate = project.endDate;
        let duration = projectStartDate - projectEndDate;

        taskGantt.push({
            id: projectId,
            text: projectName,
            start_date: projectStartDate,
            duration: duration,
            progress: 0.6, // Ajout de la propriété de progression
            open: true,
            projectId: project.id

        });
        links.push({
            id: 10, // Utilisation du même identifiant composé pour les liens
            source: 2,
            target: 3,
            type: "1"
        });

    });

    // gantt.templates.task_cell_class = function(item, date) {
    //     if (date === item.start_date) {
    //         return "gantt-project-start";
    //     } else if (date === item.end_date) {
    //         return "gantt-project-end";
    //     }
    //     return "";
    // };

    gantt.init("gantt-chart");
    gantt.config.date_format = "%d/%m/%Y";
    gantt.config.columns = [{
            name: "text",
            label: "Projet",
            width: "250",
            tree: true,
            resize: true
        },
        {
            name: "start_date",
            label: "Date début",
            width: "140",
            align: "center"
        },
        {
            name: "duration",
            label: "Durée",
            width: "50",
            align: "center"
        },
    ];
    gantt.parse({
        data: taskGantt,
        // links: links
    });
</script> --}}
<script>
     projectData = @json($userProjects);
     console.log(projectData[0])
    // Données de votre projet
    let taskGantt = [];

   
    var projectData = {
        data: [{
                id: 1,
                text: projectData[0].name,
                start_date: projectData[0].startDate,
                duration: 10
            },
            {
                id: 2,
                text: "N/A",
                start_date: "2023-12-28",
                duration: 3
            },
            // Ajoutez les autres tâches ici
        ],
        // links: [{
        //         id: 1,
        //         source: 1,
        //         target: 2,
        //         type: "0"
        //     },
        //     // Ajoutez les autres liens de dépendance ici
        // ]
    };

    // Initialise le diagramme de Gantt
    gantt.init("gantt-chart");
    // gantt.config.date_format = "%d/%m/%Y";
    gantt.parse(projectData);
</script>
