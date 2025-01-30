<div class="bg-white shadow-md rounded-lg p-6">
    <h2 class="text-2xl font-semibold mb-6">Notes</h2>

    <div class="my-4 flex justify-between gap-6">
        <div class="w-full md:w-1/2">
            <label for="note" class="block text-sm font-medium mb-2">Add a Note</label>
            <textarea id="note" name="note" maxlength="150"
                oninput="updateCharCount('noteCount', this.value.length, 150);"
                class="py-3 px-4 block w-full border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500"
                rows="6"></textarea>
            <div class="flex justify-between mt-2">
                <small class="text-xs text-gray-500"><span id="noteCount">0</span> / 150 characters</small>
                <button type="button" onclick="addNote()" class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Add
                </button>
            </div>
        </div>

        <div class="w-full md:w-1/2">
            <label class="block text-sm font-medium mb-2">Added Notes</label>
            <ul id="notesList" class="list-none p-0">

            </ul>
        </div>
    </div>

    <input type="hidden" name="notes" id="notesInput">
</div>

<script>
    function addNote() {
        const noteText = document.getElementById("note").value.trim();
        if (noteText.length === 0) {
            alert("Please enter a note before adding.");
            return;
        }

        const li = document.createElement("li");
        li.classList.add("text-gray-700", "p-2", "flex", "justify-between", "items-center", "mb-2", "bg-gray-100", "rounded-md");

        li.innerHTML = `
        ${noteText} 
        <button class="text-red-500 hover:text-red-700" onclick="removeNote(this)">×</button>
    `;

        document.getElementById("notesList").appendChild(li);

        updateNotesInput();

        document.getElementById("note").value = "";
        document.getElementById("noteCount").textContent = "0";
    }

    function removeNote(button) {
        const li = button.closest("li");
        li.remove();

        updateNotesInput();
    }

    function updateNotesInput() {
        const notes = [];
        const notesList = document.getElementById("notesList").children;

        for (let i = 0; i < notesList.length; i++) {
            notes.push(notesList[i].textContent.trim().replace("×", "").trim());
        }

        document.getElementById("notesInput").value = JSON.stringify(notes);

    }
</script>