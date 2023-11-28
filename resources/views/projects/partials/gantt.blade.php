<div id="gantt-chart" style="width: 100%; height: 500px;"></div>
@vite('node_modules/dhtmlx-gantt/codebase/sources/dhtmlxgantt.css')
<script src="{{ Vite::asset('node_modules/dhtmlx-gantt/codebase/sources/dhtmlxgantt.js') }}"></script>
<script>
    const parentData = @json($projectOptionttmJalon); // Données des tâches parents
    const childData = @json($demandeByJalon); // Données des tâches enfants
    let taskGantt = [];
    const links = [];
    const childTasks = [];

    parentData.forEach(parent => {
        const parentId = parent.id;
        let echeance = new Date(parent.echeance);
        let debutDate = new Date(parent.debutDate);
        let diffMonth = echeance - debutDate;
        let diffDays = diffMonth / 86400000;
        const jalonId = parent.jalon_id;
        const jalon = @json($jalons).find(j => j.id ===
            jalonId); // Faire une recherche dans le tableau des jalons pour trouver celui correspondant

        // Créer la tâche parent
        taskGantt.push({
            id: jalon.id,
            text: jalon.designation,
            start_date: debutDate,
            duration: diffDays,
            progress: 0.6,
            open: true,
            jalonId: jalon.id
        });

        // Créer les tâches enfants liée

        childData.forEach(child => {
            const deadLineNoFormat = child.deadLine;
            const deadLine = parseInt(deadLineNoFormat, 10);
            let startDate = new Date(child.date_prevue);
            const titleOfDemande = @json($titleOfDemandes).find(j => j.demande_id === child
                .demande_id);

            if (child.jalon_id === jalonId) {
                childTasks.push({
                    id: `${jalonId}-${child.id}`, // Utilisation d'un identifiant composé
                    text: titleOfDemande.title + ', Assignée à : ' + child.contributeur,
                    start_date: startDate,
                    duration: deadLine,
                    parent: jalonId
                });

                links.push({
                    id: `${jalonId}-${child.id}`, // Utilisation du même identifiant composé pour les liens
                    source: jalonId,
                    target: `${jalonId}-${child.id}`,
                    type: "1"
                });
            }
        });



        taskGantt.push(...childTasks);
        console.log(childTasks);
        //taskGantt= [...taskGantt, ...childTasks];
    });

    //console.log('task', taskGantt);

    gantt.init("gantt-chart");
    gantt.config.date_format = "%d/%m/%Y";
    gantt.config.columns = [{
            name: "text",
            label: "Tâche",
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
            name: "owner",
            label: "Contributeur",
            width: "195",
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
        links: links
    });
</script>
