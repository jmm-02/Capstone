
<style>
        /* Styling the entire scrollbar */
        ::-webkit-scrollbar {
            width: 9px; /* Width of the scrollbar */
        }

        /* Styling the track (background of the scrollbar) */
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        /* Styling the draggable part of the scrollbar (the "thumb") */
        ::-webkit-scrollbar-thumb {
            background-color: #888;
            border-radius: 10px;
            border: 2px solid #f1f1f1; /* Adjust the border color as needed */
        }

        /* Hover effect for the thumb */
        ::-webkit-scrollbar-thumb:hover {
            background-color: #555;
        }

        /* Optional: Styling the scrollbar's corner when both horizontal and vertical scrollbars are visible */
        ::-webkit-scrollbar-corner {
            background: #f1f1f1;
        }

        /* Applying custom scrollbar to a specific element */
        .custom-scrollbar {
            overflow: scroll;
        }
    </style>