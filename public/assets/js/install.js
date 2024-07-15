function groupSet(groups) {
    return groups.map((data, i) => {
        const { name } = data;
        return `<span class="text-primary">${name}</span>; `;
    })
}
