import type { Metadata } from "next";
import { Noto_Sans_TC } from "next/font/google";

const notoSansTc = Noto_Sans_TC({
  preload: false,
});

export const metadata: Metadata = {
  title: "Frontend",
};

export default function RootLayout({
  children,
}: {
  children: React.ReactNode;
}) {
  return (
    <html lang="zh-Hant">
      <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tocas/4.2.5/tocas.min.css" />
        <script defer src="https://cdnjs.cloudflare.com/ajax/libs/tocas/4.2.5/tocas.min.js"></script>
        <title>Frontend</title>
      </head>
      <body className={notoSansTc.className}>{children}</body>
    </html>
  );
}
