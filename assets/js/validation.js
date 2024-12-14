const validation = new JustValidate("#signup-form");

validation
 .addField("#first-name", [
    {
        rule: "required"
    }
])

.addField("#last-name", [
    {
        rule: "required"
    }
])

.addField("#email", [
    {
        rule: "required"
    },
    {
        rule: "email"
    }
]);