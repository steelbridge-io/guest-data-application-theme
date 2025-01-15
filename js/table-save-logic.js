
document.addEventListener("DOMContentLoaded", () => {
    const table = document.querySelector("#gda-table");
    const saveButton = document.createElement("button");
    saveButton.textContent = "Save Changes";
    saveButton.setAttribute("type", "button");
    saveButton.classList.add("btn", "btn-success");
    saveButton.style.margin = "10px";

    // Add button below the table
    table.parentNode.appendChild(saveButton);

    let updates = [];

    // Track edits made in contenteditable spans
    table.addEventListener("input", (event) => {
        const target = event.target;

        if (target.tagName === "SPAN" && target.hasAttribute("contenteditable")) {
            // Get necessary data from the <span>
            const entryId = target.closest("tr").getAttribute("data-entry-id");
            const fieldLabel = target.getAttribute("data-field-label");
            const updatedValue = target.textContent.trim();

            console.log("Entry ID:", entryId); // Debug: Check entry ID
            console.log("Field Label:", fieldLabel); // Debug: Check field label
            console.log("Updated Value:", updatedValue); // Debug: Check updated data

            if (entryId && fieldLabel) {
                // Find if this edit exists in updates; if not, add it
                const existingUpdate = updates.find(
                    (update) => update.entryId === entryId && update.fieldLabel === fieldLabel
                );

                if (existingUpdate) {
                    existingUpdate.updatedValue = updatedValue;
                } else {
                    updates.push({ entryId, fieldLabel, updatedValue });
                }
            }
        }
    });

    // Save all updates when Save button is clicked
    saveButton.addEventListener("click", () => {
        if (updates.length === 0) {
            alert("No changes to save.");
            return;
        }

        // Use Ajax to save each change
        updates.forEach((data) => {
            const ajaxData = {
                action: "update_gravity_form_entry",
                security: ajax_object.security,
                entry_id: data.entryId,
                field_label: data.fieldLabel,
                updated_value: data.updatedValue,
            };

            console.log("Sending Ajax data:", ajaxData); // Debug: Check individual Ajax requests

            fetch(ajax_object.ajax_url, {
                method: "POST",
                credentials: "same-origin",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: new URLSearchParams(ajaxData).toString(),
            })
                .then((response) => response.json())
                .then((result) => {
                    if (result.success) {
                        console.log("Entry updated successfully for", data);
                    } else {
                        console.error("Error updating entry:", result.message, data);
                    }
                })
                .catch((error) => console.error("Error:", error));
        });

        // Clear updates array after saving
        updates = [];
        alert("Changes saved!");
    });
});

(function ($) {
    /** Listen for updates */
    $('td[contenteditable=true]').on('blur', function () {
        const entryId = $(this).closest('tr').data('entry-id');
        const fieldLabel = $(this).data('field-label');
        const updatedValue = $(this).text();

        $.post(ajax_object.ajax_url, {
            action: "update_gravity_form_entry",
            security: ajax_object.security, // The nonce
            entry_id: entryId,
            field_label: fieldLabel,
            updated_value: updatedValue
        }, function (response) {
            if (response.success) {
                console.log("Entry updated successfully!", response.message);
            } else {
                console.error("Error updating entry:", response.message);
            }
        });
    });
})(jQuery);