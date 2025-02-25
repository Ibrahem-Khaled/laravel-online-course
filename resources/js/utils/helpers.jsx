// src/utils/helpers.js
export const extractAndShortenLinks = (inputText) => {
    return inputText.split(/\s+/).map((word, index) => {
        if (word.match(/(https?:\/\/[^\s]+)/g)) {
            const shortUrl = word.length > 30 ? word.slice(0, 30) + "..." : word;
            return (
                <a key={index} href={word} target="_blank" rel="noopener noreferrer">
                    {shortUrl}
                </a>
            );
        }
        return word + " ";
    });
};