// src/utils/helpers.js
export const formatTextWithLinks = (text) => {
    if (!text) return '';

    // تعبير عادي للكشف عن الروابط
    const urlRegex = /(https?:\/\/[^\s]+)/g;

    return text.split(urlRegex).map((part, index) => {
        if (index % 2 === 1) { // إذا كان جزء من الرابط
            return (
                <a
                    key={index}
                    href={part}
                    target="_blank"
                    rel="noopener noreferrer"
                    style={{ color: '#00b4d8', textDecoration: 'underline' }}
                >
                    {part}
                </a>
            );
        }
        return part;
    });
};