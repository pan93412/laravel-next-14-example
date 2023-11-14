import api from "@/fetcher/endpoint";
import z from "zod";

export type Student = z.infer<typeof StudentSchema>;
export const StudentSchema = z.object({
  name: z.string(),
  address: z.string(),
  birth: z.date(),
});

export type Students = z.infer<typeof StudentsSchema>;
export const StudentsSchema = z.array(StudentSchema);

export async function getAllStudents(): Promise<Students> {
  const response = await fetch(api("students"));
  if (!response.ok) {
    const raw = await response.text();
    throw new Error(`Unable to receive students due to (${response.status}) ${raw}`);
  }

  const json = await response.json();
  return StudentsSchema.parse(json);
}
