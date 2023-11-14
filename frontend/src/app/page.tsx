import { StudentTable } from "@/app/table";
import { getAllStudents } from "@/fetcher/student.actions";

export default async function Home() {
  const students = await getAllStudents();

  return (
    <main className="ts-container">
      <div className="ts-content">
        <StudentTable data={students} />
      </div>
    </main>
  );
}
