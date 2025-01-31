/**
 * Handles AJAX for the table editing function
 * */
document.addEventListener("DOMContentLoaded", () => {
    const table = document.querySelector("#gda-table");
    /* const saveButton = document.createElement("button");
    saveButton.textContent = "Save Changes";
    saveButton.setAttribute("type", "button");
    saveButton.classList.add("btn", "btn-danger", "table-save-btn");
    saveButton.style.margin = "10px";

    // Add "Save Changes" button below the table
    table.parentNode.appendChild(saveButton); */


        const saveButton = document.createElement("button");
        saveButton.textContent = "Save Changes";
        saveButton.setAttribute("type", "button");
        saveButton.classList.add("btn", "btn-danger", "table-save-btn");
        saveButton.style.margin = "10px";

        // Add "Save Changes" button inside the last col-md-3 within gda-search-wrapper
        const colMd3 = document.querySelector(".gda-search-wrapper .row .col-md-2.save-btn");
        colMd3.appendChild(saveButton);




    let updates = [];

    // Helper function for AJAX request
    const saveEntry = (entryId, fieldLabel, updatedValue, successCallback) => {
        const requestData = {
            action: "update_gravity_form_entry",
            security: ajax_object.security,
            entry_id: entryId,
            field_label: fieldLabel,
            updated_value: updatedValue,
        };

        fetch(ajax_object.ajax_url, {
            method: "POST",
            credentials: "same-origin",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: new URLSearchParams(requestData).toString(),
        })
            .then((response) => response.json())
            .then((result) => {
                if (result.success) {
                    console.log(`Entry (${entryId}, ${fieldLabel}) updated successfully.`);
                    if (successCallback) successCallback(result);
                } else {
                    console.error("Failed to update entry:", result.message || "Unknown error");
                    alert(`Error saving entry: ${result.message || "Unknown error"}`);
                }
            })
            .catch((error) => {
                console.error("AJAX error:", error);
                alert("An error occurred while saving. Please try again.");
            });
    };

    // Listener for handling in-place contenteditable updates (less-than-fifty)
    table.addEventListener("input", (event) => {
        const target = event.target;

        if (target.tagName === "SPAN" && target.hasAttribute("contenteditable")) {
            const isLessThanFifty = target.classList.contains("less-than-fifty");
            const entryId = target.closest("tr").getAttribute("data-entry-id");
            const fieldLabel = target.getAttribute("data-field-label");
            const updatedValue = target.textContent.trim();

            // For "less-than-fifty", enforce validation to stay under 50 characters
            if (isLessThanFifty && updatedValue.length > 50) {
                alert("Value exceeds 50 characters! Changes won’t be saved.");
                return;
            }

            if (entryId && fieldLabel) {
                const existingUpdate = updates.find(
                    (update) => update.entryId === entryId && update.fieldLabel === fieldLabel
                );

                if (existingUpdate) {
                    existingUpdate.updatedValue = updatedValue;
                } else {
                    updates.push({
                        entryId,
                        fieldLabel,
                        updatedValue,
                        fieldType: isLessThanFifty ? "less-than-fifty" : "standard-textarea",
                    });
                }
            }
        }
    });

    // Listener for handling edit button clicks (more-than-fifty)
    table.addEventListener("click", (event) => {
        // Listener for "more-than-fifty" fields
        if (event.target.classList.contains("edit-long-textarea-btn")) {
            handleMoreThanFiftyEdit(event.target);
        }

        // Listener for "standardtext-more-than-fifty" fields
        if (event.target.classList.contains("edit-long-textarea-btn-two")) {
            handleStandardTextMoreThanFiftyEdit(event.target);
        }
    });

// Function to handle editing for "more-than-fifty"
    function handleMoreThanFiftyEdit(button) {
        const entryId = button.getAttribute("data-entry-id");
        const fieldLabel = button.getAttribute("data-field-label");
        const fullContent = button.getAttribute("data-full-content");

        if (!entryId || !fieldLabel || fullContent === null) {
            console.error("Missing data for 'more-than-fifty' editing.");
            alert("Unable to edit this field due to missing data.");
            return;
        }

        console.log("Editing more-than-fifty: ", { entryId, fieldLabel, fullContent });

        const cell = button.closest("td");

        replaceCellWithTextarea(cell, entryId, fieldLabel, fullContent, "more-than-fifty");
    }

// Function to handle editing for "standardtext-more-than-fifty"
    function handleStandardTextMoreThanFiftyEdit(button) {
        const entryId = button.getAttribute("data-entry-id");
        const fieldLabel = button.getAttribute("data-field-label");
        const fullContent = button.getAttribute("data-full-content");

        if (!entryId || !fieldLabel || fullContent === null) {
            console.error("Missing data for 'standardtext-more-than-fifty' editing.");
            alert("Unable to edit this field due to missing data.");
            return;
        }

        console.log("Editing standardtext-more-than-fifty: ", { entryId, fieldLabel, fullContent });

        const cell = button.closest("td");

        replaceCellWithTextarea(cell, entryId, fieldLabel, fullContent, "standardtext-more-than-fifty");
    }

// Helper function to replace the table cell with a textarea
    function replaceCellWithTextarea(cell, entryId, fieldLabel, fullContent, fieldType) {
        const textarea = document.createElement("textarea");
        textarea.value = fullContent; // Preload textarea with full content
        textarea.classList.add("edit-textarea");

        const saveButton = document.createElement("button");
        saveButton.textContent = "Save";
        saveButton.classList.add("btn", "btn-danger", "save-edit-btn");

        const cancelButton = document.createElement("button");
        cancelButton.textContent = "Cancel";
        cancelButton.classList.add("btn", "btn-danger", "cancel-edit-btn");

        cell.innerHTML = ""; // Clear the cell
        cell.appendChild(textarea);
        cell.appendChild(saveButton);
        cell.appendChild(cancelButton);

        // Save Button Logic
        saveButton.addEventListener("click", () => {
            const updatedValue = textarea.value.trim();

            const requestData = {
                action: "update_gravity_form_entry",
                security: ajax_object.security,
                entry_id: entryId,
                field_label: fieldLabel,
                updated_value: updatedValue,
            };

            fetch(ajax_object.ajax_url, {
                method: "POST",
                credentials: "same-origin",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: new URLSearchParams(requestData).toString(),
            })
                .then((response) => response.json())
                .then((result) => {
                    if (result.success) {
                        console.log(`Entry updated successfully for ${fieldType}:`, result);

                        const truncatedValue =
                            updatedValue.length > 50 ? updatedValue.substring(0, 50) + "..." : updatedValue;

                        cell.innerHTML = `
                        <span class="${fieldType}" contenteditable="false" data-field-label="${fieldLabel}" data-full-content="${updatedValue}">
                            ${truncatedValue}
                        </span>
                        <button class="${fieldType === 'more-than-fifty' ? 'edit-long-textarea-btn' : 'edit-long-textarea-btn-two'}" data-entry-id="${entryId}" data-field-label="${fieldLabel}" data-full-content="${updatedValue}">Edit</button>
                    `;
                    } else {
                        console.error("Error saving entry for", fieldType, result.message);
                        alert(`Error saving entry: ${result.message}`);
                    }
                })
                .catch((error) => {
                    console.error("AJAX error:", error);
                    alert("An error occurred while saving. Please try again.");
                });
        });

        // Cancel Button Logic
        cancelButton.addEventListener("click", () => {
            cell.innerHTML = `
            <span class="${fieldType}" contenteditable="false" data-field-label="${fieldLabel}" data-full-content="${fullContent}">
                ${fullContent}
            </span>
            <button class="${fieldType === 'more-than-fifty' ? 'edit-long-textarea-btn' : 'edit-long-textarea-btn-two'}" data-entry-id="${entryId}" data-field-label="${fieldLabel}" data-full-content="${fullContent}">Edit</button>
        `;
        });
    }
    // Save Changes button logic (global)
    saveButton.addEventListener("click", () => {
        if (updates.length === 0) {
            alert("No changes to save.");
            return;
        }

        updates.forEach((data) => {
            const { entryId, fieldLabel, updatedValue } = data;
            saveEntry(entryId, fieldLabel, updatedValue, () => {
                console.log(`Change for entry ${entryId}, field ${fieldLabel}, saved successfully.`);
            });
        });

        // Clear updates queue once changes are saved
        updates = [];
        alert("Changes saved successfully!");
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